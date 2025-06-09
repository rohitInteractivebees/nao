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


class SchoolStudents extends Component
{
    use WithPagination;

    public $school;
    public $schoolName;
    public $search = '';

    public function mount()
    {
        $this->school = request()->query('school');
        $this->schoolName = Instute::select('name')->where('id',$this->school)->value('name');
        $this->search = request()->query('search', $this->search);
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $is_login = auth()->user();

        if (auth()->user()->is_admin && $this->school) {
            $query = User::where('id', '!=', $is_login->id)
                         ->where(function ($query) {
                             $query->where('is_college', 0)
                                   ->orWhereNull('is_college');
                         });

            $query->where('institute', $this->school);
            if (!empty($this->search)) {
                $searchTerm = '%' . $this->search . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'like', $searchTerm)
                      ->orWhere('email', 'like', $searchTerm)
                      ->orWhere('phone', 'like', $searchTerm);
                });
            }
            $students = $query->paginate(20);

            return view('livewire.admin.school-students', [
                'students' => $students,
            ]);
        } else {
            Auth::logout();
            return redirect()->route('login');
        }
    }

    // public function export()
    // {
    //     $is_login = auth()->user();
    //     $quizId = request('quiz_id1');
    //     $classId = request('class_id');
    //     if (auth()->user()->is_admin) {
    //         $students = User::where('id', '!=', $is_login->id)
    //                 ->where(function ($query) {
    //                     $query->where('is_college', 0)->orWhereNull('is_college');
    //                 });
    //          if ($quizId == 'Other') {
    //             $students->where('institute', $quizId);
    //         } elseif ($quizId > 0) {
    //             $students->where('institute', $quizId);
    //         }

    //         if ($classId > 0) {
    //             $students->whereRaw('JSON_CONTAINS(class, \'\"' . $classId . '\"\')');
    //         }

    //         $students = $students->get();

    //         $csvData = [];
    //         $csvData[] = ['Sr.No', 'School Name', 'Student Name', 'Class', 'Session Year', 'Parent Name', 'Parent Email', 'Parent Phone', 'Country', 'State', 'City', 'Pincode', 'Registration Date','status'];

    //         foreach ($students as $index => $student) {
    //             $instituteName = $student->institute !== 'Other'
    //                 ? Instute::where('id', $student->institute)->value('name')
    //                 : 'Other (' . $student->school_name . ')';

    //             $classNames = Classess::whereIn('id', json_decode($student->class ?? '[]'))->pluck('name')->join(', ');

    //             $TestAtmp = Test::where('user_id', $student->id)->first();
    //             if($TestAtmp)
    //             {
    //                 $userquizatmp = 'Attempt';
    //             }
    //             else{
    //                 $userquizatmp = 'Pending';
    //             }
    //             $email = !empty($student->email) ? $student->email : 'N/A';

    //             $csvData[] = [
    //                 $index + 1,
    //                 $instituteName,
    //                 $student->name,
    //                 $classNames,
    //                 $student->session_year,
    //                 $student->parent_name,
    //                 $email,
    //                 ($student->country_code || $student->phone) ? '+' . trim($student->country_code . ' ' . $student->phone) : 'N/A',
    //                 $student->country,
    //                 $student->state,
    //                 $student->city,
    //                 $student->pincode,
    //                 $student->created_at->format('d-m-Y'),
    //                 $userquizatmp,
    //             ];
    //         }

    //         // Convert array to CSV
    //         $filename = 'students_export_' . now()->format('Y_m_d_H_i_s') . '.csv';
    //         $handle = fopen('php://temp', 'r+');

    //         foreach ($csvData as $row) {
    //             fputcsv($handle, $row);
    //         }

    //         rewind($handle);
    //         $csvOutput = stream_get_contents($handle);
    //         fclose($handle);

    //         return Response::make($csvOutput, 200, [
    //             'Content-Type' => 'text/csv',
    //             'Content-Disposition' => "attachment; filename=\"$filename\"",
    //         ]);
    //     } else {
    //         Auth::logout();
    //         return redirect()->route('login');
    //     }
    // }
}
