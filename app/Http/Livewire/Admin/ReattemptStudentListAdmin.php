<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReattemptMail;

class ReattemptStudentListAdmin extends Component
{
    use WithPagination;

    public $quiz_id1 = 0;
    public $search = '';
    public $selectedStudents = [];
    public $selectAll = false;
    public $students_selected;

    protected $updatesQueryString = ['quiz_id1', 'search'];

    protected $listeners = ['allowUser'];


    public function mount()
    {
        $this->quiz_id1 = request()->query('quiz_id1', $this->quiz_id1);
        $this->search = request()->query('search', $this->search);
    }

    public function updatingQuizId1()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function confirmAllow($userId)
    {
        $this->dispatchBrowserEvent('confirmAllow', ['userId' => $userId]);
    }
    public function allowUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->attempt_count = 0;
            $user->quiz_allow_block = 1;
            $user->save();

            if($user->email != '' && $user->email != null)
            {
                $AdminEmail = User::where('is_admin', 1)->value('email');
                try {
                    Mail::to($user->email)->cc($AdminEmail)->send(new ReattemptMail($user->name));
                } catch (\Throwable $e) {

                }
            }
            session()->flash('success', 'Reattempt allowed successfully.');
        }
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
        abort_if(!auth()->user()->is_admin, HttpResponse::HTTP_FORBIDDEN, '403 Forbidden');
        User::whereIn('id', $this->selectedStudents)->update([
            'attempt_count' => 0,
            'quiz_allow_block' => 1,
        ]);

        foreach($this->selectedStudents as $user_id)
        {
            $user = User::find($user_id);
            if($user)
            {
                if($user->email != '' && $user->email != null)
                {
                    $AdminEmail = User::where('is_admin', 1)->value('email');
                    try {
                        Mail::to($user->email)->cc($AdminEmail)->send(new ReattemptMail($user->name));
                    } catch (\Throwable $e) {

                    }
                }
            }
        }
        $this->selectedStudents = [];
        $this->selectAll = false;
        session()->flash('success', 'Reattempt allowed successfully.');
    }
    public function render()
    {
        $is_login = auth()->user();

        if ($is_login->is_admin) {
            $query = User::where('id', '!=', $is_login->id)
                         ->where('attempt_count', '>', 0)
                         ->whereNull('quiz_allow_block')
                         ->where(function ($query) {
                             $query->where('is_college', 0)
                                   ->orWhereNull('is_college');
                         })
                         ->whereNotIn('id', function ($subquery) {
                             $subquery->select('user_id')->from('tests');
                         });

            if ($this->quiz_id1 == 'Other') {
                $query->where('institute', $this->quiz_id1);
            } elseif ($this->quiz_id1 > 0) {
                $query->where('institute', $this->quiz_id1);
            }

            if (!empty($this->search)) {
                $searchTerm = '%' . $this->search . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'like', $searchTerm)
                      ->orWhere('email', 'like', $searchTerm)
                      ->orWhere('phone', 'like', $searchTerm)
                      ->orWhere('loginId', 'like', $searchTerm);
                });
            }
            $this->students_selected = $query->get();
            $students = $query->paginate(10);

            return view('livewire.admin.reattempt-student-list-admin', [
                'students' => $students,
            ]);
        } else {
            Auth::logout();
            return redirect()->route('login');
        }
    }
}
