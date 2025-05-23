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

   
    // dd($this->quiz_id);
    $user_ids = [];

    if ($this->quiz_id > 0) {
        $users = User::where('institute', $this->quiz_id)->get();
        $user_ids = $users->pluck('id')->toArray();
    }

    $tests = Test::query()
    ->whereHas('user')
    ->with(['user' => function ($query) {
        $query->select('id', 'name', 'institute');
    }, 'quiz' => function ($query) {
        $query->select('id', 'title')
              ->withCount('questions');
    }])
    ->when($this->quiz_id > 0, function ($query) use ($user_ids) {
        $query->whereIn('user_id', $user_ids);
    })
    ->orderBy('result', 'desc')
    ->orderBy('time_spent')
    ->take(40)
    ->get();

// Extract the user IDs from the top 40 tests
$topUserIds = $tests->pluck('user_id')->toArray();

// if ($this->quiz_id > 0) {
//     // Update is_selected for the top 40 users to 1
//     User::whereIn('id', $topUserIds)
//         ->where('institute', $this->quiz_id)
//         ->update(['is_selected' => 1]);

//     // Update is_selected for the rest of the users to 0
//     User::whereNotIn('id', $topUserIds)
//         ->where('institute', $this->quiz_id)
//         ->update(['is_selected' => 0]);
// }


    return view('livewire.front.leaderboard', compact('tests'));
   }

   elseif(auth()->user()->is_college == 1)
   {

   

    $college_login = auth()->user()->institute;
     
    $user_ids = [];

    if ($college_login > 0) {
        $users = User::where('institute', $college_login)->get();
        $user_ids = $users->pluck('id')->toArray();
    }
    
    $tests = Test::query()
        ->whereHas('user')
        ->with(['user' => function ($query) {
            $query->select('id', 'name');
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

// if ($college_login > 0) {
//     // Update is_selected for the top 40 users to 1
//     User::whereIn('id', $topUserIds)
       
//         ->update(['is_selected' => 1]);

//     // Update is_selected for the rest of the users to 0
//     User::whereNotIn('id', $topUserIds)
       
//         ->update(['is_selected' => 0]);
// }

    return view('livewire.front.leaderboard', compact('tests'));
   }else{
    return view('404');
   }

}


    // public function render(): View
    // {
    //     if(auth()->user()->is_admin == 1)
    //     {
    //         $user_ids = [];
    //         if ($this->quiz_id > 0) {
    //             $users = User::where('institute', $this->quiz_id)->get();
    //             $user_ids = $users->pluck('id')->toArray();
    //         }
    //         // dd($this->quiz_id);
    //         $tests = Test::query()
    //             ->whereHas('user')
    //             ->with(['user' => function ($query) {
    //                 $query->select('id', 'name','institute');
    //             }, 'quiz' => function ($query) {
    //                 $query->select('id', 'title')
    //                     ->withCount('questions');
    //             }])
    //             ->when($this->quiz_id > 0, function ($query) use ($user_ids) {
    //                 $query->whereIn('user_id', $user_ids);
    //             })
    //             ->orderBy('result', 'desc')
    //             ->orderBy('time_spent')
    //             ->take(40)
    //             ->get();

    //         $selected_user_ids = $tests->pluck('user.id')->toArray();

    //         User::whereIn('id', $selected_user_ids)->update(['is_selected' => 1]);

    //         User::whereNotIn('id', $selected_user_ids)->update(['is_selected' => 0]);

    //         return view('livewire.front.leaderboard', compact('tests'));
    //     }
    //     elseif(auth()->user()->is_college == 1)
    //     {
    //         $college_login = auth()->user()->institute;
    //         // dd($college_login);
    //         $user_ids = [];

    //         if ($college_login > 0) {
    //             $users = User::where('institute', $college_login)->get();
    //             $user_ids = $users->pluck('id')->toArray();
    //         }
    //         $tests = Test::query()
    //             ->whereHas('user')
    //             ->with(['user' => function ($query) {
    //                 $query->select('id', 'name');
    //             }, 'quiz' => function ($query) {
    //                 $query->select('id', 'title')
    //                     ->withCount('questions'); 
    //             }])
    //             ->when($user_ids > 0, function ($query) use ($user_ids) {
    //                 $query->whereIn('user_id', $user_ids);
    //             })
    //             ->orderBy('result', 'desc')
    //             ->orderBy('time_spent')
    //             ->take(40)
    //             ->get();

    //         $selected_user_ids = $tests->pluck('user.id')->toArray();

    //         User::whereIn('id', $selected_user_ids)->update(['is_selected' => 1]);

    //         User::whereNotIn('id', $selected_user_ids)->update(['is_selected' => 0]);

    //         return view('livewire.front.leaderboard', compact('tests'));
    //     }
    //     else
    //     {
    //         return view('404');
    //     }
    // }


}
