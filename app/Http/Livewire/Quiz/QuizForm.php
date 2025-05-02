<?php

namespace App\Http\Livewire\Quiz;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Test;
use App\Models\User;
use App\Models\Instute;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Mail\QuizPublishMail;
use App\Mail\QuizResultMail;
use App\Mail\QuizResultInstituteMail;
use Illuminate\Support\Facades\Mail;
use DB;

class QuizForm extends Component
{
    public Quiz $quiz;

    public array $questions = [];

    public bool $editing = false;

    public array $listsForFields = [];

    protected $rules = [
        'quiz.title' => 'required|string',
        'quiz.slug' => 'string',
        'quiz.description' => 'nullable|string',
        'quiz.published' => 'boolean',
        'quiz.public' => 'boolean',
        'quiz.published' => 'boolean',
        'questions' => 'nullable|array',
        'quiz.result_show' => 'boolean',
    ];

    public function mount(Quiz $quiz)
    {

        $this->quiz = $quiz;
        $this->initListsForFields();

        if ($this->quiz->exists) {
            $this->editing = true;
            $this->questions = $this->quiz->questions()->pluck('id')->toArray();
        } else {
            $this->quiz->published = false;
            $this->quiz->public = false;
        }
    }

    public function updatedQuizTitle(): void
    {
        $this->quiz->slug = Str::slug($this->quiz->title);
    }

    public function save()
    {
        $this->validate();
        $institute = Instute::get();
        $this->quiz->save();

        $this->quiz->questions()->sync($this->questions);
        // $top_students_by_institute = [];

        // foreach ($institute as $value) {
        //     // Fetch the top 40 test results for the current institute using raw SQL
        //     $top_students = DB::table('tests')
        //         ->join('users', 'tests.user_id', '=', 'users.id')
        //         ->join('quizzes', 'tests.quiz_id', '=', 'quizzes.id')
        //         ->where('users.institute', $value->id)
        //         ->select('tests.*', 'users.name', 'users.institute', 'quizzes.title')
        //         ->orderBy('tests.result', 'desc')
        //         ->orderBy('tests.time_spent')
        //         ->take(40)
        //         ->get();

        //     $top_students_by_institute[$value->id] = $top_students;
        // }




       // dd($top_students_by_institute);
        // if($this->quiz->published)
        // {
        //     $all_student_email = $this->fetchAllEmails();
        //     foreach ($all_student_email as $email) {
        //         //Mail::to($email->email)->send(new QuizPublishMail($email->name));
        //         Mail::to('sunnyb.ibees@gmail.com')->send(new QuizPublishMail($email->name));
        //         break;
        //     }
        // }
        if($this->quiz->result_show)
        {

            foreach ($institute as $value) {
                // Get users belonging to the current institute
                $users = User::where('institute', $value->id)->get();
                $user_ids = $users->pluck('id')->toArray();

                // Fetch all test results for the current institute's users
                $tests = Test::query()
                    ->whereIn('user_id', $user_ids)
                    ->with(['user' => function ($query) {
                        $query->select('id', 'name', 'institute');
                    }, 'quiz' => function ($query) {
                        $query->select('id', 'title')->withCount('questions');
                    }])
                    ->orderBy('result', 'desc')
                    ->orderBy('time_spent')
                    ->get();

                // Group by user and get the top 40 students
                $top_students = $tests->groupBy('user_id')->map(function ($group) {
                    return $group->sortByDesc('result')->first();
                })->sortByDesc('result')->take(40);

                $top_student_ids = $top_students->pluck('user_id')->toArray();

                // Update is_selected column for these students
                User::whereIn('id', $top_student_ids)->update(['is_selected' => 1]);
            }
            $is_college_email = User::where('is_college', 1)->pluck('email');
            foreach ($is_college_email as $email) {
                //Mail::to($email)->send(new QuizResultInstituteMail);
            }

            $all_student_email = $this->fetchAllEmails();
            foreach ($all_student_email as $email) {
                //Mail::to($email->email)->send(new QuizResultMail($email->name));
            }
        }
        return to_route('quizzes');
    }

    protected function initListsForFields()
    {
        $this->listsForFields['questions'] = Question::pluck('text', 'id')->toArray();
    }
    protected function fetchAllEmails()
    {
        return User::select('email','name')->where('is_admin', '!=', 1)
                    ->where(function ($query){
                        $query->where('is_college', '!=', 1)
                                ->orWhereNull('is_college');
                    })->get();
    }
    public function render(): View
    {
        return view('livewire.quiz.quiz-form');
    }
}
