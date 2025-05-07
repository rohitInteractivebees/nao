<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Test;

class HomeController extends Controller
{
    public function index()
    {
        $query = Quiz::whereHas('questions')
             ->withCount('questions')
            ->when(auth()->guest() || !auth()->user()->is_admin, function ($query) {
                return $query->where('published', 1);
            })
            ->get();

        $public_quizzes = $query->where('public', 1);
        $registered_only_quizzes = $query->where('public', 0);

        $liveQuiz = null;
        if(auth()->check() && !auth()->user()->is_admin && is_null(auth()->user()->is_college))
        {
            $liveQuiz = Quiz::whereHas('questions')
                    ->withCount('questions')
                    ->when(auth()->check() && !auth()->user()->is_admin && is_null(auth()->user()->is_college), function ($query) {
                        $userClasses = json_decode(auth()->user()->class ?? '[]', true); // e.g., [1, 2]

                        if (!empty($userClasses)) {
                            $query->whereIn('class_ids', $userClasses);
                        }

                        $query->where('status', 1);
                    })
                    ->limit(1)
                    ->get();

        }

        return view('home', compact('public_quizzes', 'registered_only_quizzes','liveQuiz'));
    }

    public function show(Quiz $quiz)
    {
        // $test = Test::where('user_id',auth()->user()->id)->first();
        // //dd($test);
        // if(!$test)
        // {
          return view('front.quizzes.show', compact('quiz'));
        // }
        // else{
        //     return redirect()->back()->with('message', 'Allready Done');

        // }
    }
}
