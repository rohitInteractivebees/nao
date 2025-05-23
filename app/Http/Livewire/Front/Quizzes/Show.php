<?php

namespace App\Http\Livewire\Front\Quizzes;

use App\Models\Question;
use App\Models\Option;
use App\Models\Quiz;
use App\Models\Test;
use App\Models\Answer;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

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
        $result = 0;

        $test = Test::create([
            'user_id' => auth()->id(),
            'quiz_id' => $this->quiz->id,
            'result' => 0,
            'ip_address' => request()->ip(),
            'time_spent' => now()->timestamp - $this->startTimeInSeconds
        ]);

        foreach ($this->answersOfQuestions as $key => $optionId) {


            if (!empty($optionId) && Option::find($optionId)->correct) {

                $result += $this->questions[$key]->marks;
                Answer::create([
                    'user_id' => auth()->id(),
                    'test_id' => $test->id,
                    'question_id' => $this->questions[$key]->id,
                    'option_id' => $optionId,
                    'correct' => 1
                ]);
            } else {


                if (!empty($optionId))
                {
                    Answer::create([

                        'user_id' => auth()->id(),
                        'test_id' => $test->id,
                        'question_id' => $this->questions[$key]->id,
                        //'option_id' => $optionId,
                        'option_id' => $optionId,
                    ]);
                }
                else{
                    Answer::create([

                        'user_id' => auth()->id(),
                        'test_id' => $test->id,
                        'question_id' => $this->questions[$key]->id,


                    ]);
                }





            }
        }

        $test->update([
            'result' => $result
        ]);

        return to_route('quiz.congratulation', ['test' => $test]);

        //return to_route('results.show', ['test' => $test]);
    }

    public function render(): View
    {
        return view('livewire.front.quizzes.show');
    }
}
