<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Instute;
use Livewire\Component;
use App\Models\Classess;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentListAdmin extends Component
{
    use WithPagination;

    public $quiz_id1 = 0;

    protected $updatesQueryString = ['quiz_id1'];

    public function mount()
    {
        $this->quiz_id1 = request()->query('quiz_id1', $this->quiz_id1);
    }
    public function updatingQuizId1()
    {
        $this->resetPage();
    }
    public function delete(User $admin)
    {
        abort_if(!auth()->user()->is_admin, Response::HTTP_FORBIDDEN, '403 Forbidden');

        $admin->delete();
    }

    public function render()
    {
        $is_login = auth()->user();

        if (auth()->user()->is_admin) {
            $query = User::where('id', '!=', $is_login->id)
                         ->where(function ($query) {
                             $query->where('is_college', 0)
                                   ->orWhereNull('is_college');
                         });

            if ($this->quiz_id1 == 'Other') {
                $query->where('institute', $this->quiz_id1);
            }else {
                if ($this->quiz_id1 > 0) {
                    $query->where('institute', $this->quiz_id1);
                }
            }

            $students = $query->paginate(10);

            return view('livewire.admin.student-list-admin', [
                'students' => $students,
            ]);
        } else {
            Auth::logout();
            return redirect()->route('login');
        }
    }
    public function uploadCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);
        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        //$csvData = array_map('str_getcsv', file($path));
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
        if(!($headerData[1] == 'school_code') || !($headerData[2] == 'student_name') || !($headerData[3] == 'class') || !($headerData[4] == 'session_year') || !($headerData[5] == 'parent_name') || !($headerData[6] == 'parent_email') || !($headerData[7] == 'parent_country_code') || !($headerData[8] == 'parent_phone') || !($headerData[9] == 'country') || !($headerData[10] == 'state') || !($headerData[11] == 'city') || !($headerData[12] == 'pincode')){

                return response()->json([
                    'success' => false,
                    'message' => 'CSV file is improperly formatted.'
                ]);
        }
        foreach ($csvData as $key => $row) {
            if ($key === 0) continue; // Skip header
            // Ensure minimum column count
            if (count($row) < 13) continue;

            // Trim all fields first
            $row = array_map('trim', $row);

            [
                $index, $schoolCode, $studentName, $class, $sessionYear, $parentName,
                $parentEmail, $parentCountryCode, $phone, $country, $state, $city, $pincode
            ] = $row;

            // Check if any required field is blank
            if (
                $schoolCode === '' || $studentName === '' || $class === '' || $sessionYear === '' ||
                $parentName === '' || $parentEmail === '' || $parentCountryCode === '' || $phone === '' ||
                $country === '' || $state === '' || $city === '' || $pincode === ''
            ) {
                continue; // Skip incomplete rows
            }

            $classId = (int) $class - 5;

            // Check if already exists
            $emailExists = User::where('email', $parentEmail)->exists();
            $phoneExists = User::where('phone', $phone)->exists();
            //$loginIdExists = User::where('loginId', $loginId)->exists();
            $classExists = Classess::where('id', $classId)->exists();
            $schoolExists = Instute::where('code', $schoolCode)->exists();
            //dd($emailExists,$phoneExists,$loginIdExists,$classExists);

            if ($emailExists || $phoneExists || !$classExists || !$schoolExists) {
                continue; // Skip if duplicate or invalid class ID
            }
            //dd('test');

            // Ensure it's an array before encoding
            if (is_array($classId)) {
                $encodedClassname = json_encode($classId);
            } else {
                $encodedClassname = json_encode([(string) $classId]);
            }
            $schoolData = Instute::where('code',$schoolCode)->first();
            $schoolCode = $schoolData->code;
            $lastUser = User::where('reg_no', 'LIKE', $schoolCode . '_%')
            ->orderByRaw("CAST(SUBSTRING_INDEX(reg_no, '_', -1) AS UNSIGNED) DESC")
            ->first();

            $lastNumber = 0;
            if ($lastUser && preg_match('/_(\d+)$/', $lastUser->reg_no, $matches)) {
            $lastNumber = (int) $matches[1];
            }

            $newRegNo = $schoolCode . '_' . ($lastNumber + 1);
            // Create user
            User::create([
                'name' => $studentName,
                'parent_name' => $parentName,
                'email' => $parentEmail,
                'institute' => $schoolData->id,
                'class' => $encodedClassname,
                'country' => $country,
                'state' =>$state,
                'city' =>$city,
                'session_year' => $sessionYear,
                'phone' => $phone,
                //'password' => Hash::make($request->password),
                'password' => Hash::make($phone),
                'reg_no' => $newRegNo,
                'loginId' => $parentEmail,
                'is_verified' => 1,
                'country_code' => $parentCountryCode,
                'pincode' => $pincode,
            ]);

            // Optional: send email
            // Mail::to($spocEmail)->send(new WelcomeEmail($schoolName, $spocEmail, $spocName));
        }

        return response()->json([
            'success' => true,
            'message' => 'CSV uploaded and users created successfully.'
        ]);
    }
}
