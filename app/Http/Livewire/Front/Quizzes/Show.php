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
        $user = auth()->user();

        $user->increment('attempt_count');

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
        if (empty($this->answersOfQuestions[$this->currentQuestionIndex])) {
            $this->addError('answersOfQuestions.' . $this->currentQuestionIndex, 'Please select an option before continue.');
            return;
        }
        $this->currentQuestionIndex++;

        if ($this->currentQuestionIndex >= $this->questionsCount) {
            return $this->submit();
        }
        else{
            $this->currentQuestion = $this->questions[$this->currentQuestionIndex];
        }
    }

    public function submit()
    {
        $result = 0;

        $existingTest = Test::where('user_id', auth()->id())
                            ->where('quiz_id', $this->quiz->id)
                            ->first();

        if ($existingTest) {
            return to_route('home');
        }

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

       return to_route('home');

    }

    public function render(): View
    {
        $user = auth()->user();
        $attempt_count = $user->attempt_count;
        if($attempt_count > 1) {
            return view('content.quiz_notification');
        }else{
            return view('livewire.front.quizzes.show',compact('attempt_count'));
        }
    }
}
