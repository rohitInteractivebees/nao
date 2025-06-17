<?php
namespace App\Http\Livewire\Admin;

use App\Models\Quiz;
use App\Models\Test;
use App\Models\User;
use App\Models\Instute;
use Livewire\Component;
use App\Models\Classess;
use App\Mail\VarifyEmail;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
//use App\Jobs\SendWelcomeEmail;
class StudentList extends Component
{
    use WithPagination;


    public $quiz_id = 1;
    public $class_id = '';
    public $search = '';

     // Optional: Set default values
    public function mount()
    {
        $this->quiz_id = request()->query('quiz_id', $this->quiz_id);
        $this->class_id = request()->query('class_id', $this->class_id);
        $this->search = request()->query('search', $this->search);
    }

    public function updatingClassId()
    {
        $this->resetPage();
    }

    public function updatingQuizId()
    {
        $this->resetPage();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $is_login = auth()->user();

        if ($is_login && $is_login->is_college == 1) {
            $id = $is_login->institute;

            $query = User::where('institute', $id)->where('id', '!=', $is_login->id);

            if ($this->quiz_id == 2) {
                $query->where('is_verified', 1);
            } elseif ($this->quiz_id == 3) {
                $query->where(function ($q) {
                    $q->where('is_verified', 0)->orWhereNull('is_verified');
                });
            }
            if($this->class_id != '')
            {
                $query->whereRaw('JSON_CONTAINS(class, \'\"' . $this->class_id . '\"\')');
            }
            if (!empty($this->search)) {
                $searchTerm = '%' . $this->search . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'like', $searchTerm)
                      ->orWhere('email', 'like', $searchTerm)
                      ->orWhere('phone', 'like', $searchTerm);
                });
            }
            $student = $query->paginate(10);
            $classes = Classess::orderBy('id','asc')->get();
            return view('livewire.admin.student-list', [
                'student' => $student,
                'classes' => $classes
            ]);
        } else {
            Auth::logout();
        }
    }
    public function export()
    {
        $is_login = auth()->user();
        $quizId = $is_login->institute;
        $classId = request('class_id');
        if (auth()->user()->is_college == 1) {
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
            $csvData[] = ['Sr.No', 'Student Name', 'Class','Section', 'Session Year', 'Parent Name', 'Parent Email', 'Parent Phone', 'Country', 'State', 'City', 'Pincode', 'Registration Date','status'];

            foreach ($students as $index => $student) {

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

                $csvData[] = [
                    $index + 1,
                    $student->name,
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
        // Header processing
        $headerData = $csvData[0];
        if (
            !isset($headerData[1]) || $headerData[1] !== 'student_name' ||
            !isset($headerData[2]) || $headerData[2] !== 'class' ||
            !isset($headerData[3]) || $headerData[3] !== 'section' ||
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

        $is_login = auth()->user();
        $id = $is_login->institute;
        $schoolData = Instute::find($id);
        $schoolCode = $schoolData->code;
        foreach ($csvData as $key => $row) {
            if ($key === 0) continue; // Skip header
            // Ensure minimum column count
            if (count($row) < 13) continue;

            $row = array_map('trim', $row);

            [
                $index, $studentName, $class, $section, $sessionYear, $parentName,
                $parentEmail, $parentCountryCode, $phone, $country, $state, $city, $pincode
            ] = $row;

            if (
                $studentName === '' || $class === '' || $sessionYear === '' || $parentName === '' || $country === '' || $state === '' || $city === '' || $pincode === '' || strlen($section) > 15
            ) {
                continue;
            }

            // Convert class to integer (in case it's a string like "6")
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

            // Ensure it's an array before encoding
            if (is_array($classId)) {
                $encodedClassname = json_encode($classId);
            } else {
                $encodedClassname = json_encode([(string) $classId]);
            }


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

            // Create user
            User::create([
                'name' => $studentName,
                'parent_name' => $parentName,
                'email' => $parentEmail,
                'institute' => $id,
                'class' => $encodedClassname,
                'section' => $section,
                'country' => $country,
                'state' =>$state,
                'city' =>$city,
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
            // if($parentEmail != '')
            // {
            //     $classIds = json_decode($encodedClassname, true);

            //     if (!empty($classIds)) {
            //         $classNames = \App\Models\Classess::whereIn('id', $classIds)->pluck('group')->toArray();
            //         $matchedGroup = implode(', ', $classNames);
            //         $pdf = 'Olympiad_Questionnaire_Group'.$matchedGroup.'.pdf';
            //     }
            //     SendWelcomeEmail::dispatch($studentName, $parentEmail, $phone, $pdf);
            // }
            // Optional: send email
            // Mail::to($spocEmail)->send(new WelcomeEmail($schoolName, $spocEmail, $spocName));
        }
        // Save the modified CSV for download
        $fileName = 'Student_Registration(School-'.$schoolCode.')_' . now()->format('d-m-Y_H-i-s') . '.csv';
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



    public function verifyAdmin(Request $request, $id)
    {
        $admin = User::find($id);
        if ($admin) {
            $admin->is_verified = $request->verify;
            $admin->remark = $request->remark;
            $admin->save();
        // Mail::to($admin->email)->send(new VarifyEmail($admin->name));
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'password' => 'required|min:6',
        ]);
        $user = User::find($request->user_id);
        $user->password = Hash::make($request->password);
        $user->save();

        session()->flash('success', 'Password updated successfully!');
        return redirect()->back()->with('success', 'Password updated successfully!');
    }
}
