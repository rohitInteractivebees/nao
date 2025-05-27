<?php

namespace App\Http\Livewire\Front\Results;

use App\Models\Test;
use Livewire\Component;

class ResultList extends Component
{
    public function render()
    {
        $tests = Test::select('id', 'result', 'time_spent', 'user_id', 'quiz_id', 'created_at')
            ->where('user_id', auth()->id())
            ->withCount('questions')
            ->with(['quiz' => function ($query) {
                $query->select('id', 'title', 'description','result_date','pass_fail_percent');
                $query->withCount('questions');
                $query->with(['questions' => function ($q) {
                    $q->select('questions.id', 'marks'); // only fetch required fields
                }]);
            }])
            ->paginate();

    // dd($tests);

        return view('livewire.front.results.result-list', [
            'tests' => $tests
        ]);
    }
}
