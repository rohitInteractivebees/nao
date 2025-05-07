<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Instute;
use Livewire\Component;
use App\Models\Classess;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;

class CollegeList extends Component
{
    public function delete(User $admin)
    {
        abort_if(!auth()->user()->is_admin, Response::HTTP_FORBIDDEN, 403);

        $admin->delete();
    }

    public function render(): View
    {
        $admins = User::where('is_college',1)->paginate();

        return view('livewire.admin.college-list', [
            'admins' => $admins
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
            return response()->json([
                'success' => false,
                'message' => 'CSV file is empty or improperly formatted.'
            ]);
        }
        $headerData = $csvData[0];
        if(!($headerData[1] == 'school_name') || !($headerData[2] == 'principal_name') || !($headerData[3] == 'mobile') || !($headerData[4] == 'country') || !($headerData[5] == 'state') || !($headerData[6] == 'city') || !($headerData[7] == 'spoc_name') || !($headerData[8] == 'spoc_email') || !($headerData[9] == 'spoc_mobile') || !($headerData[10] == 'login_id') || !($headerData[11] == 'password')){
            return response()->json([
                'success' => false,
                'message' => 'CSV file is improperly formatted.'
            ]);
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

        return response()->json([
            'success' => true,
            'message' => 'CSV uploaded and schools created successfully.'
        ]);
    }

}
