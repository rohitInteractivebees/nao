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
        if(\Carbon\Carbon::now()->gte(\Carbon\Carbon::parse($test->quiz->result_date))  || auth()->user()->is_admin)
        {
            $questions_count = Answer::where('test_id', $test->id)->count();

            $total_questions_count = Answer::where('test_id', $test->id)
            ->join('questions', 'answers.question_id', '=', 'questions.id')
            ->sum('questions.marks');

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

                return view('front.quizzes.result', compact('test', 'questions_count', 'results', 'leaderboard','total_questions_count'));
            }

            return view('front.quizzes.result', compact('test', 'questions_count', 'results','total_questions_count'));

        }
        Auth::logout();
    }
}
