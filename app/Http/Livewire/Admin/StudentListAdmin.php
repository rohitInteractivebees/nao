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

    public int $quiz_id1 = 0;

    protected $updatesQueryString = ['quiz_id1'];

    public function updatedQuizId1()
    {
        // Reset pagination when the filter changes
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

            if ($this->quiz_id1 > 0) {
                $query->where('institute', $this->quiz_id1);
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
        $csvData = array_map('str_getcsv', file($path));
        if (empty($csvData) || count($csvData) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'CSV file is empty or improperly formatted.'
            ]);
        }
        $headerData = $csvData[0];
        if(!($headerData[1] == 'school_code') || !($headerData[2] == 'student_name') || !($headerData[3] == 'class_id') || !($headerData[4] == 'session_year') || !($headerData[5] == 'parent_name') || !($headerData[6] == 'parent_email') || !($headerData[7] == 'phone') || !($headerData[8] == 'state') || !($headerData[9] == 'city') || !($headerData[10] == 'login_id') || !($headerData[11] == 'password')){
            return response()->json([
                'success' => false,
                'message' => 'CSV file is improperly formatted.'
            ]);
        }
        foreach ($csvData as $key => $row) {
            if ($key === 0) continue; // Skip header
            // Ensure minimum column count
            if (count($row) < 12) continue;

            [
                $index,$schoolCode, $studentName, $classId, $sessionYear, $parentName, $parentEmail, $phone,
                $state, $city, $loginId, $password
            ] = array_map('trim', $row);

            // Check if already exists
            $emailExists = User::where('email', $parentEmail)->exists();
            $phoneExists = User::where('phone', $phone)->exists();
            $loginIdExists = User::where('loginId', $loginId)->exists();
            $classExists = Classess::where('id', $classId)->exists();
            $schoolExists = Instute::where('code', $schoolCode)->exists();
            //dd($emailExists,$phoneExists,$loginIdExists,$classExists);

            if ($emailExists || $phoneExists || $loginIdExists || !$classExists || !$schoolExists) {
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
}
