<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class AllowReattemptStudentListAdmin extends Component
{
    use WithPagination;

    public $quiz_id1 = 0;
    public $search = '';

    protected $updatesQueryString = ['quiz_id1', 'search'];



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


    public function render()
    {
        $is_login = auth()->user();

        if ($is_login->is_admin) {
            $query = User::where('id', '!=', $is_login->id)
                         ->where('quiz_allow_block',1)
                         ->where(function ($query) {
                             $query->where('is_college', 0)
                                   ->orWhereNull('is_college');
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
            $students = $query->paginate(10);
            return view('livewire.admin.allowreattempt-student-list-admin', [
                'students' => $students,
            ]);
        } else {
            Auth::logout();
            return redirect()->route('login');
        }
    }
}
