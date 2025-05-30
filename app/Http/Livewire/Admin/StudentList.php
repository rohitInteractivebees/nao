<?php
namespace App\Http\Livewire\Admin;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Instute;
use Livewire\Component;
use App\Models\Classess;
use App\Mail\VarifyEmail;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\WithPagination;
//use App\Jobs\SendWelcomeEmail;
class StudentList extends Component
{
    use WithPagination;


    public $quiz_id = 1;
    public $class_id = '';

     // Optional: Set default values
    public function mount()
    {
        $this->quiz_id = request()->query('quiz_id', $this->quiz_id);
        $this->class_id = request()->query('class_id', $this->class_id);
    }

    public function updatingClassId()
    {
        $this->resetPage();
    }

    public function updatingQuizId()
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
        if(!($headerData[1] == 'student_name') || !($headerData[2] == 'class') || !($headerData[3] == 'session_year') || !($headerData[4] == 'parent_name') || !($headerData[5] == 'parent_email') || !($headerData[6] == 'parent_country_code') || !($headerData[7] == 'parent_phone') || !($headerData[8] == 'country') || !($headerData[9] == 'state') || !($headerData[10] == 'city') || !($headerData[11] == 'pincode')){

            return response()->json([
                'success' => false,
                'message' => 'CSV file is improperly formatted.'
            ]);
        }
        $is_login = auth()->user();
        $id = $is_login->institute;
        foreach ($csvData as $key => $row) {
            if ($key === 0) continue; // Skip header
            // Ensure minimum column count
            if (count($row) < 12) continue;

            // Trim and assign variables
            [
                $index, $studentName, $class, $sessionYear, $parentName,
                $parentEmail, $parentCountryCode, $phone, $country,
                $state, $city, $pincode
            ] = array_map('trim', $row);

            // Check for any blank required fields
            if (
                $studentName === '' || $class === '' || $sessionYear === '' || $parentName === '' ||
                $parentEmail === '' || $parentCountryCode === '' || $phone === '' || $country === '' ||
                $state === '' || $city === '' || $pincode === ''
            ) {
                continue; // Skip this row
            }

            // Convert class to integer (in case it's a string like "6")
            $classId = (int) $class - 5;
            // Check if already exists
            $emailExists = User::where('email', $parentEmail)->exists();
            $phoneExists = User::where('phone', $phone)->exists();
            //$loginIdExists = User::where('loginId', $loginId)->exists();
            $classExists = Classess::where('id', $classId)->exists();

            if ($emailExists || $phoneExists || !$classExists) {
                continue; // Skip if duplicate or invalid class ID
            }
            //dd('test');

            // Ensure it's an array before encoding
            if (is_array($classId)) {
                $encodedClassname = json_encode($classId);
            } else {
                $encodedClassname = json_encode([(string) $classId]);
            }
            $schoolData = Instute::find($id);
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
                'institute' => $id,
                'class' => $encodedClassname,
                'country' => $country,
                'state' =>$state,
                'city' =>$city,
                'session_year' => $sessionYear,
                'phone' => $phone,
                //'password' => Hash::make($request->password),
                'password' => Hash::make($phone),
                'reg_no' => $newRegNo,
                //'loginId' => $loginId,
                'loginId' => $parentEmail,
                'is_verified' => 1,
                'country_code' => $parentCountryCode,
                'pincode' => $pincode,
            ]);
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
        return response()->json([
            'success' => true,
            'message' => 'CSV uploaded and users created successfully.'
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
