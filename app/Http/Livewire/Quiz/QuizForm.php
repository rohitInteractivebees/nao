<?php

namespace App\Http\Livewire\Quiz;

use DB;
use App\Models\Quiz;
use App\Models\Test;
use App\Models\User;
use App\Models\Instute;
use Livewire\Component;
use App\Models\Question;
use Illuminate\Support\Str;
use App\Mail\QuizResultMail;
use App\Mail\QuizPublishMail;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuizResultInstituteMail;

class QuizForm extends Component
{
    public Quiz $quiz;
    public $questions = [];
    public bool $editing = false;
    public $class_ids;
    public array $questionOptions = [];
    public array $groups = [];
    public $selectedGroup = null;


    protected function rules()
    {
        return [
            'quiz.title' => 'required|string',
            'quiz.start_date' => 'required',
            'quiz.end_date' => 'required|after_or_equal:start_date',
            'quiz.result_date' => 'required|after_or_equal:end_date',
            'selectedGroup' => [
                'required',
                Rule::in([1, 2, 3]),
                Rule::unique('quizzes', 'class_ids')->ignore($this->quiz->id),
            ],
            
        ];
    }

    public function mount(Quiz $quiz)
    {
        $this->groups = [1,2,3];
        $this->quiz = $quiz;
        if ($this->quiz->exists) {
            $this->selectedGroup = $quiz->class_ids;
            $this->editing = true;
            $this->questions = $this->quiz->questions()->pluck('id')->toArray();
        }
    }

    public function save()
    {
        $this->validate();
        // Only select 30 random questions on creation
        $this->questions = Question::where('class_ids', $this->selectedGroup)->get();
        if (count($this->questions) > 0) {
            
            $classIds = $this->selectedGroup;
            $this->quiz->slug = Str::slug($this->quiz->title);
            $this->quiz->status = 1;
            $this->quiz->class_ids = $classIds;
            $this->quiz->duration = 30;
            $this->quiz->total_question = 120;
            $this->quiz->save();
            
            $syncData = [];

            foreach ($this->questions as $question) {
                // Assume each question is an object or array with id and level
                // Adjust accordingly if it's structured differently
                $questionId = is_array($question) ? $question['id'] : $question->id;
                $questionLevel = is_array($question) ? $question['level'] : $question->level;
            
                $syncData[$questionId] = ['question_level' => $questionLevel];
            }
            
            // Sync with pivot data
            $this->quiz->questions()->sync($syncData);
            return to_route('quizzes');
        }else {
            session()->flash('message', 'Not enough questions in the question bank.');
            return;
        }
    }

    public function render(): View
    {
        return view('livewire.quiz.quiz-form');
    }
}
