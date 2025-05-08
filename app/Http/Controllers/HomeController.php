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
        $test = Test::where('user_id', auth()->id())->where('quiz_id', $quiz->id)->first();

        if ($test) {
            return redirect()->route('home')->with('message', 'You have already attempted this quiz.');
        }

        if (auth()->check() && !auth()->user()->is_admin && is_null(auth()->user()->is_college)) {
            $userClasses = json_decode(auth()->user()->class ?? '[]', true); // e.g., [1, 2]

            if (!empty($userClasses) && !in_array($quiz->class_ids, $userClasses)) {
                return redirect()->route('home')->with('message', 'This quiz is not assigned to your class.');
            }

            if ($quiz->status != 1 || !\Carbon\Carbon::now()->between(\Carbon\Carbon::parse($quiz->start_date),\Carbon\Carbon::parse($quiz->end_date)
                )
            ) {
                return redirect()->route('home')->with('message', 'This quiz is not currently available.');
            }

            return view('front.quizzes.show', compact('quiz'));
        }

        return redirect()->route('home');
    }

}
