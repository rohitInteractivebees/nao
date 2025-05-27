<?php

namespace App\Http\Livewire\Front;

use App\Models\Quiz;
use App\Models\Test;
use App\Models\User;
use App\Models\Instute;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Leaderboard extends Component
{
    public Collection $quizzes;

    public int $quiz_id = 0;

    public function mount()
    {
        $this->quizzes = Quiz::published()->get();
        $this->college = Instute::get();
    }

    public function render(): View
    {
        if(auth()->user()->is_admin == 1)
        {
            $user_ids = [];

            if ($this->quiz_id == 'Other') {
                $users = User::where('institute', $this->quiz_id)->get();
                $user_ids = $users->pluck('id')->toArray();
            }elseif ($this->quiz_id > 0) {
                $users = User::where('institute', $this->quiz_id)->get();
                $user_ids = $users->pluck('id')->toArray();
            }

            $tests = Test::query()
                ->whereHas('user')
                ->with(['user' => function ($query) {
                    $query->select('id', 'name', 'institute','class','school_name','email');
                }, 'quiz' => function ($query) {
                $query->select('id', 'title','duration')
                    ->withCount('questions');
                }])
                ->when($this->quiz_id > 0, function ($query) use ($user_ids) {
                    $query->whereIn('user_id', $user_ids);
                })
                ->withCount('questions')
                ->orderBy('result', 'desc')
                ->orderBy('time_spent')
                ->take(40)
                ->get();
            // Extract the user IDs from the top 40 tests
            $topUserIds = $tests->pluck('user_id')->toArray();

            return view('livewire.front.leaderboard', compact('tests'));

        }else if(auth()->user()->is_college == 1){

            $college_login = auth()->user()->institute;

            $user_ids = [];

            if ($college_login > 0) {
                $users = User::where('institute', $college_login)->get();
                $user_ids = $users->pluck('id')->toArray();
            }

            $tests = Test::query()
                ->whereHas('user')
                ->with(['user' => function ($query) {
                    $query->select('id', 'name','class','email');
                }, 'quiz' => function ($query) {
                    $query->select('id', 'title')
                        ->withCount('questions');
                }])
                ->when($user_ids > 0, function ($query) use ($user_ids) {
                    $query->whereIn('user_id', $user_ids);
                })
                ->orderBy('result', 'desc')
                ->orderBy('time_spent')
                ->take('40')
                ->get();

            // Extract the user IDs from the top 40 tests
            $topUserIds = $tests->pluck('user_id')->toArray();

            return view('livewire.front.leaderboard', compact('tests'));
        }else{
            return view('404');
        }
    }

}
