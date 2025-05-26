<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Classess;
use App\Models\User;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;

class ClassList extends Component
{
    public function render(): View
    {
        $classes = Classess::all();
    
        // Get total quiz attempts per user
        $totalAttempts = \App\Models\Test::selectRaw('user_id, COUNT(*) as total_tests')
            ->groupBy('user_id')
            ->pluck('total_tests', 'user_id'); // returns [user_id => total_tests]
    
        foreach ($classes as $class) {
            // Get users of the current class (non-admin, non-college)
            $userall = \App\Models\User::where('is_admin', 0)
                ->where(function ($query) {
                    $query->where('is_college', '!=', 1)
                          ->orWhereNull('is_college');
                })
                ->whereRaw('JSON_CONTAINS(class, \'\"' . $class->id . '\"\')');
            if(auth()->user()->is_admin == 0)
            {
                $userall->where('institute',auth()->user()->institute)->where('id','!=',auth()->user()->id);
            }
            $users = $userall->get();
            // Set user count
            $class->user_count = $users->count();
    
            // Calculate total quiz attempts for users in this class
            $class->quiz_attempts = $users->sum(function ($user) use ($totalAttempts) {
                return $totalAttempts[$user->id] ?? 0;
            });
        }
    
        return view('livewire.admin.class-list', [
            'classes' => $classes
        ]);
    }


    public function verifySchool(Request $request, $id)
    {
        $admin = User::find($id);
        if ($admin) {
            $admin->is_verified = $request->verify;
            $admin->save();
            if ($admin->institute) {
                $institute = Instute::find($admin->institute);
                if ($institute) {
                    $institute->status = 1;
                    $institute->save();
                }
            }
          // Mail::to($admin->email)->send(new VarifyEmail($admin->name));
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
    public function uploadCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $csvData = array_map('str_getcsv', file($path));

        if (empty($csvData) || count($csvData) < 2) {
            return redirect()->back()->with('error', 'CSV file is empty or improperly formatted.');
        }

        $classIds = Classess::pluck('id')->toArray();
        $encodedClassIds = json_encode(array_map('strval', $classIds));

        foreach ($csvData as $key => $row) {
            if ($key === 0) continue; // Skip header

            // Ensure minimum column count
            if (count($row) < 12) continue;

            [
                $index, $schoolName, $principalName, $mobile, $country,
                $state, $city, $spocName, $spocEmail, $spocMobile,
                $loginId, $password
            ] = array_map('trim', $row);

            // Check if already exists
            $exists = User::where('email', $spocEmail)->exists() ||
                    User::where('phone', $mobile)->exists() ||
                    User::where('spoc_mobile', $spocMobile)->exists() ||
                    Instute::where('name', $schoolName)->exists() ||
                    User::where('loginId', $loginId)->exists();

            if ($exists) {
                continue; // Skip duplicate entry
            }

            // Create institute
            $institute = Instute::create([
                'name' => $schoolName,
                'status' => 1,
            ]);

            // Generate institute code: initials + ID
            $initials = collect(explode(' ', $schoolName))
                ->filter()
                ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                ->implode('');

            $code = $initials . $institute->id;
            $institute->code = $code;
            $institute->save();

            // Create user
            User::create([
                'name' => $principalName,
                'parent_name' => $spocName,
                'email' => $spocEmail,
                'institute' => $institute->id,
                'class' => $encodedClassIds,
                'state' => $state,
                'city' => $city,
                'phone' => $mobile,
                'spoc_mobile' => $spocMobile,
                'country' => $country,
                'password' => Hash::make($password),
                'is_college' => 1,
                'reg_no' => $code,
                'loginId' => $loginId,
                'is_verified' => 1,
            ]);

            // Optional: send email
            // Mail::to($spocEmail)->send(new WelcomeEmail($schoolName, $spocEmail, $spocName));
        }

        return redirect()->back()->with('success', 'CSV uploaded and users created successfully.');
    }

}
