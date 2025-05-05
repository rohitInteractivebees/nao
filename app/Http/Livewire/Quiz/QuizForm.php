<?php

namespace App\Http\Livewire\Quiz;

use DB;
use App\Models\Quiz;
use App\Models\Test;
use App\Models\User;
use App\Models\Instute;
use Livewire\Component;
use App\Models\Classess;
use App\Models\Question;
use Illuminate\Support\Str;
use App\Mail\QuizResultMail;
use App\Mail\QuizPublishMail;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuizResultInstituteMail;

class QuizForm extends Component
{
    public Quiz $quiz;
    public array $questions = [];
    public bool $editing = false;
    public $classes = [];
    public $class_ids;
    public $total_question;
    public array $questionOptions = [];

    protected $rules = [
        'quiz.title' => 'required|string',
        'quiz.description' => 'nullable|string',
        'quiz.duration' => 'required|integer',
        'quiz.start_date' => 'required',
        'quiz.end_date' => 'required|after_or_equal:start_date',
        'quiz.result_date' => 'required|after_or_equal:end_date',
        'quiz.class_ids' => 'required|integer|unique:quizzes,class_ids',
        'quiz.total_question' => 'required|integer|min:1',
    ];

    public function mount(Quiz $quiz)
    {
         // Load all classes
         $this->classes = Classess::all();
        $this->quiz = $quiz;


        $this->class_ids = $quiz->class_ids;
        $this->total_question = $quiz->total_question;

        if ($this->quiz->exists) {
            $this->editing = true;
            $this->questions = $this->quiz->questions()->pluck('id')->toArray();
        }
    }

    public function save()
    {
        $this->validate();
        // Only select 30 random questions on creation
        $this->initListsForFields();
        $questionIds = array_keys($this->questionOptions);
        if (count($questionIds) > 0) {
            $randomKeys = count($questionIds) > $this->quiz->total_question
                ? array_rand($questionIds, $this->quiz->total_question)
                : $questionIds;

            $this->questions = is_array($randomKeys) ? $randomKeys : [$randomKeys];
        }
        if(count($this->questions) == $this->quiz->total_question && $this->quiz->total_question > 0)
        {
            $this->quiz->slug = Str::slug($this->quiz->title);
            $this->quiz->status = 1;
            $this->quiz->save();
            $this->quiz->questions()->sync($this->questions);
            return to_route('quizzes');
        }else {
            session()->flash('message', 'Not enough questions in the question bank.');
            return;
        }


    }

    protected function initListsForFields()
    {
        if($this->quiz->class_ids != null)
        {
            $this->questionOptions = Question::where(function ($query) {
                foreach ((array) $this->quiz->class_ids as $classId) {
                    $query->orWhereJsonContains('class_ids', (string) $classId);
                }
            })->pluck('text', 'id')->toArray();
        }
    }

    public function render(): View
    {
        return view('livewire.quiz.quiz-form');
    }
}
