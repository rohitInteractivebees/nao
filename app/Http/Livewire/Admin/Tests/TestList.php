<?php

namespace App\Http\Livewire\Admin\Tests;

use App\Models\Quiz;
use App\Models\Test;
use Illuminate\Support\Collection;
use Livewire\Component;
use App\Models\Instute;
use App\Models\User;
use Livewire\WithPagination;

class TestList extends Component
{
    use WithPagination;
    public Collection $quizzes;

    public $quiz_id = 0;
    public $class_id = 0;
    public $college;
    public $search = '';

    protected $updatesQueryString = ['quiz_id1','class_id'];

    public function mount()
    {
        $this->quizzes = Quiz::published()->get();
        $this->college = Instute::get();
        $this->search = request()->query('search', $this->search);
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingQuizId()
    {
        $this->resetPage();
    }
    public function updatingClassId()
    {
        $this->resetPage();
    }

    public function render()
    {

        $user_ids = [];

        if ($this->quiz_id == 'Other') {
            $users = User::where('institute', $this->quiz_id)->get();
            $user_ids = $users->pluck('id')->toArray();
        }else if ($this->quiz_id > 0) {
            $users = User::where('institute', $this->quiz_id)->get();
            $user_ids = $users->pluck('id')->toArray();
        }
        if ($this->class_id > 0) {
            $users = User::where('institute', $this->quiz_id)
                    ->whereRaw('JSON_CONTAINS(class, \'\"' . $this->class_id . '\"\')')->get();
            $user_ids = $users->pluck('id')->toArray();

        }

        $tests = Test::query()
    ->with(['user', 'quiz'])
    ->withCount('questions')
    ->when($this->quiz_id > 0, function ($query) use ($user_ids) {
        $query->whereIn('user_id', $user_ids);
    })
    ->when(!empty($this->search), function ($query) {
        $searchTerm = '%' . $this->search . '%';

        $query->whereHas('user', function ($q) use ($searchTerm) {
            $q->where(function ($q2) use ($searchTerm) {
                $q2->where('name', 'like', $searchTerm)
                   ->orWhere('loginId', 'like', $searchTerm)
                   ->orWhere('email', 'like', $searchTerm)
                   ->orWhere('phone', 'like', $searchTerm);
            });
        });
    })
    ->latest()
    ->paginate();


            return view('livewire.admin.tests.test-list', [
            'tests' => $tests
        ]);
    }
}
