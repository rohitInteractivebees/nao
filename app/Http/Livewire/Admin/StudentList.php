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

class StudentList extends Component
{
    public  $quiz_id = 3;

    public function render(): View
    {

        $is_login = auth()->user();
         // dd($is_login);
        if ($is_login && $is_login->is_college == 1) {
            $id = $is_login->institute;

            //dd($this->quiz_id);
            //$student = User::where('institute', $id)->where('id', '!=', $is_login->id)->paginate(10);

            if ($this->quiz_id == 1) {
                $student = User::where('institute', $id)
                    ->where('id', '!=', $is_login->id)
                    ->where(function ($query) {
                    $query->where('is_verified', 0)
                        ->orWhereNull('is_verified');
                    })
                ->paginate(10);
            }
            else if($this->quiz_id == 2)
            {
                $student = User::where('institute', $id)->where('id', '!=', $is_login->id)->where('is_verified', 1)->paginate(10);
            }
            else{
                $student = User::where('institute', $id)->where('id', '!=', $is_login->id)->paginate(10);
            }
            return view('livewire.admin.student-list', [
                'student' => $student,
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
        $csvData = array_map('str_getcsv', file($path));
        if (empty($csvData) || count($csvData) < 2) {

            return response()->json([
                'success' => false,
                'message' => 'CSV file is empty or improperly formatted.'
            ]);
        }
        $headerData = $csvData[0];
        if(!($headerData[1] == 'student_name') || !($headerData[2] == 'class_id') || !($headerData[3] == 'session_year') || !($headerData[4] == 'parent_name') || !($headerData[5] == 'parent_email') || !($headerData[6] == 'phone') || !($headerData[7] == 'state') || !($headerData[8] == 'city') || !($headerData[9] == 'login_id') || !($headerData[10] == 'password')){

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
            if (count($row) < 11) continue;

            [
                $index, $studentName, $classId, $sessionYear, $parentName, $parentEmail, $phone,
                $state, $city, $loginId, $password
            ] = array_map('trim', $row);

            // Check if already exists
            $emailExists = User::where('email', $parentEmail)->exists();
            $phoneExists = User::where('phone', $phone)->exists();
            $loginIdExists = User::where('loginId', $loginId)->exists();
            $classExists = Classess::where('id', $classId)->exists();
            //dd($emailExists,$phoneExists,$loginIdExists,$classExists);

            if ($emailExists || $phoneExists || $loginIdExists || !$classExists) {
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
                'state' =>$state,
                'city' =>$city,
                'session_year' => $sessionYear,
                'phone' => $phone,
                'password' => Hash::make($password),
                'reg_no' => $newRegNo,
                'loginId' => $loginId,
                'is_verified' => 1,
            ]);

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
