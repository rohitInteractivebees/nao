<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Answer;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function show(Test $test): View
    {
        $show_result = $test->quiz->result_show;
        //dd($show_result);
        
        if($show_result == 1  || auth()->user()->is_admin)
        {
            $questions_count = 20;
        $results = Answer::where('test_id', $test->id)
            ->with('question.options')
            ->get();

        if ($test->quiz->public) {
            $leaderboard = Test::query()
                ->where('quiz_id', $test->quiz_id)
                ->whereHas('user')
                ->with(['user' => function ($query) {
                    $query->select('id', 'name');
                }])
                ->orderBy('result', 'desc')
                ->orderBy('time_spent')
                ->get();

            return view('front.quizzes.result', compact('test', 'questions_count', 'results', 'leaderboard'));
        }

        return view('front.quizzes.result', compact('test', 'questions_count', 'results'));

        }
        
        
            Auth::logout();

       
        
    }
}
