<?php

namespace App\Http\Livewire\Admin\Tests;

use App\Models\Quiz;
use App\Models\Test;
use Illuminate\Support\Collection;
use Livewire\Component;
use App\Models\Instute;
use App\Models\User;

class TestList extends Component
{
    public Collection $quizzes;

    public int $quiz_id = 0;

    public function mount()
    {
        $this->quizzes = Quiz::published()->get();
        $this->college = Instute::get();
    }

    public function render()
    {

        $user_ids = [];

        if ($this->quiz_id > 0) {
            $users = User::where('institute', $this->quiz_id)->get();
            
            $user_ids = $users->pluck('id')->toArray();
            
        }
        //dd($user_ids);
        // $tests = Test::when($this->quiz_id > 0, function ($query) {
        //     $query->whereIn('user_id', $user_ids);
            
        // })
        //     ->with(['user', 'quiz'])
        //     ->withCount('questions')
        //     ->latest()
        //     ->paginate();
        

            $tests = Test::query()
            ->with(['user', 'quiz'])
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
