<?php

namespace App\Http\Livewire\Quiz;

use Illuminate\Support\Str;
use App\Models\Quiz;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\Response;

class QuizList extends Component
{
    public $quiz; // Assuming this is the quiz you're working with
    public $newQuiz; // A new variable for the copied quiz

    public function delete($quiz_id)
    {
        abort_if(!auth()->user()->is_admin, Response::HTTP_FORBIDDEN, 403);

        Quiz::find($quiz_id)->delete();
    }


    public function copy($quiz_id)
    {
        // Fetch the existing quiz
        $quiz = Quiz::find($quiz_id);

        if ($quiz) {
            // Create a copy of the quiz
            $newQuiz = $quiz->replicate(); // Create a copy of the quiz
            $newQuiz->title = $newQuiz->title . ' (Copy)'; // Add (Copy) to the title
            $newQuiz->slug = Str::slug($newQuiz->title); // Generate a new slug
            $newQuiz->status = 0; // Set status to draft
            $newQuiz->start_date = $newQuiz->start_date; // Optionally reset dates
            $newQuiz->end_date = $newQuiz->end_date;
            $newQuiz->result_date = $newQuiz->result_date;
            $newQuiz->save(); // Save the new quiz copy

            // Copy questions (assuming many-to-many relationship)
            foreach ($quiz->questions as $question) {
                $newQuiz->questions()->attach($question->id);
            }

            session()->flash('message', 'Quiz copied successfully.');
        } else {
            session()->flash('error', 'Quiz not found.');
        }

        return;
    }

    public function render(): View
    {
        $quizzes = Quiz::withCount('questions')->latest()->paginate();
        return view('livewire.quiz.quiz-list', compact('quizzes'));
    }
}
