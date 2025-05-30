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

        $csvData = array_filter(array_map('str_getcsv', file($path)), function ($row) {
            // Remove rows where all values are empty or contain only whitespace
            return array_filter($row, function ($value) {
                return trim($value) !== '';
            });
        });

        if (empty($csvData) || count($csvData) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'CSV file is empty or improperly formatted.'
            ]);
        }
        $headerData = $csvData[0];
        if(!($headerData[1] == 'school_name') || !($headerData[2] == 'principal_name') || !($headerData[3] == 'principal_mobile') || !($headerData[4] == 'principal_email') || !($headerData[5] == 'country') || !($headerData[6] == 'state') || !($headerData[7] == 'city') || !($headerData[8] == 'spoc_name') || !($headerData[9] == 'spoc_email') || !($headerData[10] == 'spoc_mobile') || !($headerData[11] == 'principal_country_code') || !($headerData[12] == 'spoc_country_code') || !($headerData[13] == 'pincode')){
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
            if (count($row) < 14) continue;

            // Trim all values
            $row = array_map('trim', $row);

            [
                $index, $schoolName, $principalName, $mobile, $email, $country,
                $state, $city, $spocName, $spocEmail, $spocMobile, $principalCountryCode, $spocCountryCode, $pincode
            ] = $row;

            // Check for any empty value
            if (
                $schoolName === '' || $principalName === '' || $mobile === '' || $email === '' ||
                $country === '' || $state === '' || $city === '' || $spocName === '' ||
                $spocEmail === '' || $spocMobile === '' || $principalCountryCode === '' ||
                $spocCountryCode === '' || $pincode === ''
            ) {
                continue; // Skip row with any blank value
            }
            // Check if already exists
            $exists = User::where('email', $email)->exists() ||
                    User::where('phone', $mobile)->exists() ||
                    Instute::where('name', $schoolName)->exists();
            if ($exists) {
                continue; // Skip duplicate entry
            }

            // Create institute
            $institute = Instute::create([
                'name' => $schoolName,
                'status' => 1,
            ]);
            // 1. Remove all special characters except letters and spaces
            $cleanedName = preg_replace('/[^a-zA-Z\s]/', '', $schoolName);

            // 2. Replace multiple spaces with a single space
            $cleanedName = preg_replace('/\s+/', ' ', $cleanedName);

            // 3. Extract initials
            $initials = collect(explode(' ', $cleanedName))
                ->filter()
                ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                ->implode('');

            // 4. Generate the final school code with a random 2-digit number
            $code = $initials . $institute->id;
            // Generate institute code: initials + ID

            $institute->code = $code;
            $institute->save();

            // Create user
            User::create([
                'name' => $principalName,
                'parent_name' => $spocName,
                'email' => $email,
                'institute' => $institute->id,
                'class' => $encodedClassIds,
                'state' => $state,
                'city' => $city,
                'phone' => $mobile,
                'spoc_mobile' => $spocMobile,
                'country' => $country,
                //'password' => Hash::make($request->password),
                'password' => Hash::make($mobile),
                'is_college' => 1,
                'reg_no' => $code,
                //'loginId' => $loginId,
                'loginId' => $email,
                'is_verified' => 1,
                'spoc_email' => $spocEmail,
                'country_code' => $principalCountryCode,
                'spoc_country_code' => $spocCountryCode,
                'pincode' => $pincode
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
