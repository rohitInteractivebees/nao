<?php

namespace App\Http\Livewire\Front\Quizzes;

use App\Models\Quiz;
use App\Models\Test;
use App\Models\Answer;
use App\Models\Option;
use Livewire\Component;
use App\Models\Question;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;

class Show extends Component
{
    public Quiz $quiz;

    public Collection $questions;

    public Question $currentQuestion;
    public int $currentQuestionIndex = 0;

    public array $answersOfQuestions = [];

    public int $startTimeInSeconds = 0;

    public function mount()
    {
        $this->startTimeInSeconds = now()->timestamp;

        $levels = [1, 2, 3];
        $this->questions = new \Illuminate\Database\Eloquent\Collection();

        foreach ($levels as $level) {
            $questionsForLevel = Question::whereHas('quizzes', function ($query) use ($level) {
                    $query->where('quiz_id', $this->quiz->id)
                          ->where('question_level', $level);
                })
                ->with('options')
                ->inRandomOrder()
                ->limit(10)
                ->get();

            $this->questions = $this->questions->merge($questionsForLevel);
        }
        $this->questions = $this->questions->shuffle();

        // $this->questions = Question::query()
        //     ->inRandomOrder()
        //     ->whereRelation('quizzes', 'id', $this->quiz->id)
        //     ->with('options')
        //     ->get();
        // dd($this->questions);
        $this->currentQuestion = $this->questions[$this->currentQuestionIndex];

        for ($questionIndex = 0; $questionIndex < $this->questionsCount; $questionIndex++) {
            $this->answersOfQuestions[$questionIndex] = [];
        }
    }

    public function getQuestionsCountProperty(): int
    {
        return $this->questions->count();
    }

    public function nextQuestion()
    {
        $this->currentQuestionIndex++;

        if ($this->currentQuestionIndex == $this->questionsCount) {
            return $this->submit();
        }

        $this->currentQuestion = $this->questions[$this->currentQuestionIndex];
    }

    public function submit()
    {
        DB::beginTransaction();

        try {
            $result = 0;

            // Prevent duplicate test entries
            $existingTest = Test::where('user_id', auth()->id())
                                ->where('quiz_id', $this->quiz->id)
                                ->first();

            if ($existingTest) {
                return redirect()->route('quiz.congratulation', ['test' => $existingTest]);
            }

            // Create test entry
            $test = Test::create([
                'user_id' => auth()->id(),
                'quiz_id' => $this->quiz->id,
                'result' => 0,
                'ip_address' => request()->ip(),
                'time_spent' => now()->timestamp - $this->startTimeInSeconds
            ]);

            // Save answers
            foreach ($this->answersOfQuestions as $key => $optionId) {
                $questionId = $this->questions[$key]->id;
                $marks = $this->questions[$key]->marks;

                $isCorrect = !empty($optionId) && Option::find($optionId)?->correct;

                if ($isCorrect) {
                    $result += $marks;
                }

                // Create answer only if test is created
                Answer::create([
                    'user_id' => auth()->id(),
                    'test_id' => $test->id,
                    'question_id' => $questionId,
                    'option_id' => $optionId ?? null,
                    'correct' => $isCorrect ? 1 : 0,
                ]);
            }

            // Update result in test
            $test->update(['result' => $result]);

            DB::commit();

            return redirect()->route('quiz.congratulation', ['test' => $test]);

        } catch (\Exception $e) {
            DB::rollBack();

        }
    }
    public function render(): View
    {
        return view('livewire.front.quizzes.show');
    }
}
