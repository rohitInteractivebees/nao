<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class QuestionList extends Component
{
    public function delete(Question $question)
    {
        abort_if(!auth()->user()->is_admin, Response::HTTP_FORBIDDEN, 403);

        $question->delete();
    }

    public function render(): View
    {
        $questions = Question::paginate(10);

        return view('livewire.question.qusetion-list', compact('questions'));
    }
    public function uploadCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);
        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        //$csvData = array_map('str_getcsv', file($path));
        $csvData = array_filter(array_map('str_getcsv', file($path)), function ($row) {
            // Remove rows where all values are empty or contain only whitespace
            return array_filter($row, function ($value) {
                return trim($value) !== '';
            });
        });
        if (empty($csvData) || count($csvData) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'CSV file is empty or improperly formatted1.'
            ]);
        }
        $headerData = $csvData[0];
        //dd($headerData);
        if(!($headerData[1] == 'group') || !($headerData[2] == 'level') || !($headerData[3] == 'question_text') || !($headerData[4] == 'option_1') || !($headerData[5] == 'is_correct_option_1') || !($headerData[6] == 'option_2') || !($headerData[7] == 'is_correct_option_2') || !($headerData[8] == 'option_3') || !($headerData[9] == 'is_correct_option_3') || !($headerData[10] == 'option_4') || !($headerData[11] == 'is_correct_option_4')){
                
                return response()->json([
                    'success' => false,
                    'message' => 'CSV file is improperly formatted1.'
                ]);
        }
        $marks = 1;
        foreach ($csvData as $key => $row) {
            if ($key === 0) continue; // Skip header
            // Ensure minimum column count
            if (count($row) < 12) continue;

            [
                $index, $group, $level, $questionText, $option1, $isCorrectOption1, $option2, $isCorrectOption2, $option3, $isCorrectOption3, $option4, $isCorrectOption4
            ] = array_map('trim', $row);
            
            // Create user
           $question = Question::create([
                'text' => $questionText,
                'class_ids' => $group,
                'marks' => 1,
                'level' => $level,
                'text' => trim($questionText),
            ]);
            // Create Options
            $options = [
                ['text' => $option1, 'correct' => filter_var($isCorrectOption1, FILTER_VALIDATE_BOOLEAN)],
                ['text' => $option2, 'correct' => filter_var($isCorrectOption2, FILTER_VALIDATE_BOOLEAN)],
                ['text' => $option3, 'correct' => filter_var($isCorrectOption3, FILTER_VALIDATE_BOOLEAN)],
                ['text' => $option4, 'correct' => filter_var($isCorrectOption4, FILTER_VALIDATE_BOOLEAN)],
            ];
    
            foreach ($options as $opt) {
                if (!empty($opt['text'])) {
                    $question->options()->create($opt); // Assuming Question has `options()` relation
                }
            }
            
        }

        return response()->json([
            'success' => true,
            'message' => 'CSV uploaded and questions created successfully.'
        ]);
    }
}
