<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Instute;
use Livewire\Component;
use App\Models\Classess;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Illuminate\Http\Response as HttpResponse;
//use App\Jobs\SendWelcomeEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;


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
        abort_if(!auth()->user()->is_admin, HttpResponse::HTTP_FORBIDDEN, '403 Forbidden');

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

        $csvData = array_filter(array_map('str_getcsv', file($path)), function ($row) {
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

        // Header processing
        $headerData = $csvData[0];
        if (
            !isset($headerData[1]) || $headerData[1] !== 'school_code' ||
            !isset($headerData[2]) || $headerData[2] !== 'student_name' ||
            !isset($headerData[3]) || $headerData[3] !== 'class' ||
            !isset($headerData[4]) || $headerData[4] !== 'session_year' ||
            !isset($headerData[5]) || $headerData[5] !== 'parent_name' ||
            !isset($headerData[6]) || $headerData[6] !== 'parent_email' ||
            !isset($headerData[7]) || $headerData[7] !== 'parent_country_code' ||
            !isset($headerData[8]) || $headerData[8] !== 'parent_phone' ||
            !isset($headerData[9]) || $headerData[9] !== 'country' ||
            !isset($headerData[10]) || $headerData[10] !== 'state' ||
            !isset($headerData[11]) || $headerData[11] !== 'city' ||
            !isset($headerData[12]) || $headerData[12] !== 'pincode'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'CSV file is improperly formatted.'
            ]);
        }

        // Add loginId & password to the header
        $newHeader = array_merge($headerData, ['loginId', 'password']);
        $exportData = [$newHeader];

        foreach ($csvData as $key => $row) {
            if ($key === 0) continue; // Skip header

            if (count($row) < 13) continue;
            $row = array_map('trim', $row);

            [
                $index, $schoolCode, $studentName, $class, $sessionYear, $parentName,
                $parentEmail, $parentCountryCode, $phone, $country, $state, $city, $pincode
            ] = $row;

            if (
                $schoolCode === '' || $studentName === '' || $class === '' || $sessionYear === '' ||
                $parentName === '' || $country === '' || $state === '' || $city === '' || $pincode === ''
            ) {
                continue;
            }

            $classId = (int) $class - 5;

            $emailExists = $parentEmail ? User::where('email', $parentEmail)->exists() : false;
            $phoneExists = $phone ? User::where('phone', $phone)->exists() : false;

            $classExists = Classess::where('id', $classId)->exists();
            $schoolExists = Instute::where('code', $schoolCode)->exists();

            if ($emailExists || $phoneExists || !$classExists || !$schoolExists) {
                continue;
            }

            $schoolData = Instute::where('code', $schoolCode)->first();
            $schoolCode = $schoolData->code;

            $lastUser = User::where('reg_no', 'LIKE', $schoolCode . '_%')
                ->orderByRaw("CAST(SUBSTRING_INDEX(reg_no, '_', -1) AS UNSIGNED) DESC")
                ->first();

            $lastNumber = $lastUser && preg_match('/_(\d+)$/', $lastUser->reg_no, $matches)
                ? (int) $matches[1]
                : 0;

            $newRegNo = $schoolCode . '_' . ($lastNumber + 1);

            $lastLoginId = User::where('loginId', 'LIKE', $schoolCode . '_%')
                ->orderByRaw("CAST(SUBSTRING_INDEX(loginId, '_', -1) AS UNSIGNED) DESC")
                ->first();

            $lastLoginNumber = $lastLoginId && preg_match('/_(\d+)$/', $lastLoginId->loginId, $matches)
                ? (int) $matches[1]
                : 0;

            $newLoginId = $schoolCode . '_' . ($lastLoginNumber + 1);
            $plainPassword = $newLoginId;

            User::create([
                'name' => $studentName,
                'parent_name' => $parentName,
                'email' => $parentEmail,
                'institute' => $schoolData->id,
                'class' => json_encode([(string) $classId]),
                'country' => $country,
                'state' => $state,
                'city' => $city,
                'session_year' => $sessionYear,
                'phone' => $phone,
                'password' => Hash::make($plainPassword),
                'reg_no' => $newRegNo,
                'loginId' => $newLoginId,
                'is_verified' => 1,
                'country_code' => $parentCountryCode,
                'pincode' => $pincode,
            ]);

            $exportData[] = array_merge($row, [$newLoginId, $plainPassword]);
        }

        // Save the modified CSV for download
        $fileName = 'Student_Registration_' . now()->format('d-m-Y_H-i') . '.csv';
        $tempFilePath = public_path("uploadCsv/{$fileName}");

        if (!file_exists(public_path('uploadCsv'))) {
            mkdir(public_path('uploadCsv'), 0775, true);
        }

        $file = fopen($tempFilePath, 'w');
        foreach ($exportData as $line) {
            fputcsv($file, $line);
        }
        fclose($file);

        return response()->json([
            'success' => true,
            'message' => 'Upload successful!',
            'file_url' => asset("uploadCsv/{$fileName}")
        ]);
    }

}
