<?php

namespace App\Http\Livewire\Admin;

use App\Models\Test;
use App\Models\User;
use App\Models\Instute;
use Livewire\Component;
use App\Models\Classess;
use Illuminate\Http\Request;
use Livewire\WithPagination;
//use App\Jobs\SendWelcomeEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as HttpResponse;


class StudentListAdmin extends Component
{
    use WithPagination;

    public $quiz_id1 = 0;
    public $class_id = 0;
    public $search = '';
    public $selectedStudents = [];
    public $change_school = '';
    public $selectAll = false;
    public $students_selected;

    protected $updatesQueryString = ['quiz_id1','class_id','change_school'];
    protected $listeners = ['toggleStudentSelection'];

    public function mount()
    {
        $this->quiz_id1 = request()->query('quiz_id1', $this->quiz_id1);
        $this->class_id = request()->query('class_id', $this->class_id);
        $this->search = request()->query('search', $this->search);
    }
    public function updatingQuizId1()
    {
        $this->resetPage();
    }
    public function updatingClassId()
    {
        $this->resetPage();
    }
    public function delete(User $admin)
    {
        abort_if(!auth()->user()->is_admin, HttpResponse::HTTP_FORBIDDEN, '403 Forbidden');

        $admin->delete();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatedSelectedStudents()
    {
        if (count($this->selectedStudents) !== $this->students_selected->count()) {
            $this->selectAll = false;
        } else {
            $this->selectAll = true;
        }
    }
    public function updatedSelectAll($value)
    {
        if ($value) {
            // Select all students from current page
            $this->selectedStudents = $this->students_selected->pluck('id')->toArray();
        } else {
            $this->selectedStudents = [];
        }
    }

    public function updateSelected()
    {
        if($this->change_school > 0)
        {
            abort_if(!auth()->user()->is_admin, HttpResponse::HTTP_FORBIDDEN, '403 Forbidden');
            User::whereIn('id', $this->selectedStudents)->update([
                'institute' => $this->change_school, // or whatever status you want to mark as "deleted"
                'school_name' => null, // will be handled automatically if using soft deletes
            ]);
            $this->selectedStudents = [];
            $this->selectAll = false;
            session()->flash('success', 'School name updated successfully.');
        }
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
            if ($this->class_id > 0) {
                $query->whereRaw('JSON_CONTAINS(class, \'\"' . $this->class_id . '\"\')');
            }
            if (!empty($this->search)) {
                $searchTerm = '%' . $this->search . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'like', $searchTerm)
                      ->orWhere('email', 'like', $searchTerm)
                      ->orWhere('phone', 'like', $searchTerm)
                      ->orWhere('loginId', 'like', $searchTerm)
                      ->orWhere('school_name', 'like', $searchTerm);
                });
            }
            $students_all = $query->get();
            $students = $query->paginate(10);
            $this->students_selected = $students_all->filter(fn($s) => $s->institute == 'Other');
            return view('livewire.admin.student-list-admin', [
                'students' => $students,
            ]);
        } else {
            Auth::logout();
            return redirect()->route('login');
        }
    }

    public function export()
    {
        $is_login = auth()->user();
        $quizId = request('quiz_id1');
        $classId = request('class_id');
        if (auth()->user()->is_admin) {
            $students = User::where('id', '!=', $is_login->id)
                    ->where(function ($query) {
                        $query->where('is_college', 0)->orWhereNull('is_college');
                    });
             if ($quizId == 'Other') {
                $students->where('institute', $quizId);
            } elseif ($quizId > 0) {
                $students->where('institute', $quizId);
            }

            if ($classId > 0) {
                $students->whereRaw('JSON_CONTAINS(class, \'\"' . $classId . '\"\')');
            }

            $students = $students->get();

            $csvData = [];
            $csvData[] = ['Sr.No', 'School Name', 'School Code', 'Student Name', 'Login ID', 'Class','Section', 'Session Year', 'Parent Name', 'Parent Email', 'Parent Phone', 'Country', 'State', 'City', 'Pincode', 'Registration Date','status'];

            foreach ($students as $index => $student) {
                $instituteName = $student->institute !== 'Other'
                    ? Instute::where('id', $student->institute)->value('name')
                    : 'Other (' . $student->school_name . ')';

                $classNames = Classess::whereIn('id', json_decode($student->class ?? '[]'))->pluck('name')->join(', ');

                $TestAtmp = Test::where('user_id', $student->id)->first();
                if($TestAtmp)
                {
                    $userquizatmp = 'Attempt';
                }
                else{
                    $userquizatmp = 'Pending';
                }
                $email = !empty($student->email) ? $student->email : 'N/A';

                if($student->institute == 'Other')
                {
                    $school_code = explode("_",$student->reg_no)[0];
                }else{
                    $schoolData = Instute::where('id',$student->institute)->first();
                    $school_code = $schoolData->code;
                }

                $csvData[] = [
                    $index + 1,
                    $instituteName,
                    $school_code,
                    $student->name,
                    $student->loginId,
                    $classNames,
                    $student->section ?? 'N/A',
                    $student->session_year,
                    $student->parent_name,
                    $email,
                    ($student->country_code || $student->phone) ? '+' . trim($student->country_code . ' ' . $student->phone) : 'N/A',
                    $student->country,
                    $student->state,
                    $student->city,
                    $student->pincode,
                    $student->created_at->format('d-m-Y'),
                    $userquizatmp,
                ];
            }

            // Convert array to CSV
            $filename = 'students_export_' . now()->format('Y_m_d_H_i_s') . '.csv';
            $handle = fopen('php://temp', 'r+');

            foreach ($csvData as $row) {
                fputcsv($handle, $row);
            }

            rewind($handle);
            $csvOutput = stream_get_contents($handle);
            fclose($handle);

            return Response::make($csvOutput, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
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
            !isset($headerData[4]) || $headerData[4] !== 'section' ||
            !isset($headerData[5]) || $headerData[5] !== 'session_year' ||
            !isset($headerData[6]) || $headerData[6] !== 'parent_name' ||
            !isset($headerData[7]) || $headerData[7] !== 'parent_email' ||
            !isset($headerData[8]) || $headerData[8] !== 'parent_country_code' ||
            !isset($headerData[9]) || $headerData[9] !== 'parent_phone' ||
            !isset($headerData[10]) || $headerData[10] !== 'country' ||
            !isset($headerData[11]) || $headerData[11] !== 'state' ||
            !isset($headerData[12]) || $headerData[12] !== 'city' ||
            !isset($headerData[13]) || $headerData[13] !== 'pincode'
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

            if (count($row) < 14) continue;
            $row = array_map('trim', $row);

            [
                $index, $schoolCode, $studentName, $class, $section, $sessionYear, $parentName,
                $parentEmail, $parentCountryCode, $phone, $country, $state, $city, $pincode
            ] = $row;

            if (
                $schoolCode === '' || $studentName === '' || $class === '' || $sessionYear === '' ||
                $parentName === '' || $country === '' || $state === '' || $city === '' || strlen($section) > 15
            ) {
                continue;
            }

            if ($section && !preg_match('/^[a-zA-Z0-9\s\-]+$/', $section)) {
                // Skip if section contains characters other than letters, numbers, space, or hyphen
                continue;
            }
            $classId = (int) $class - 5;


            $skip = false;

            if ($parentEmail) {
                $userByEmail = User::where('email', $parentEmail)
                    ->whereRaw('LOWER(name) = ?', [trim(strtolower($studentName))])
                    ->whereRaw('JSON_CONTAINS(class, ?)', ['"' . $classId . '"'])
                    ->first();

                if ($userByEmail) {
                    $skip = true;
                }
            }

            if (!$skip && $phone) {
                $userByPhone = User::where('phone', $phone)
                    ->whereRaw('LOWER(name) = ?', [trim(strtolower($studentName))])
                    ->whereRaw('JSON_CONTAINS(class, ?)', ['"' . $classId . '"'])
                    ->first();

                if ($userByPhone) {
                    $skip = true;
                }
            }

            $classExists = Classess::where('id', $classId)->exists();
            $schoolExists = Instute::where('code', $schoolCode)->exists();
            if ($skip || !$classExists || !$schoolExists) {
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
                'section' => $section,
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
        $fileName = 'Student_Registration(Admin)_' . now()->format('d-m-Y_H-i-s') . '.csv';
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
