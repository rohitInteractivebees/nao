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

    protected $updatesQueryString = ['quiz_id1','class_id'];

    public function mount()
    {
        $this->quizzes = Quiz::published()->get();
        $this->college = Instute::get();
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
            ->latest()
            ->paginate();

            return view('livewire.admin.tests.test-list', [
            'tests' => $tests
        ]);
    }
}
