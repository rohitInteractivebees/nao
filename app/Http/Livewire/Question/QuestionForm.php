<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class QuestionForm extends Component
{
    use WithFileUploads;

    public Question $question;
    public array $options = [];
    public bool $editing = false;
    public array $groups = [];
    public $selectedGroup = null;
    public $level = null;

    protected $rules = [
        'question.text' => 'required|string',
        'options' => 'required|array|min:1',
        'options.*.text' => 'nullable|string|max:250',
        'options.*.correct' => 'nullable|boolean',
        'selectedGroup' => 'required|in:1,2,3', // use keys from your $groups array
        'level' => 'required|in:1,2,3', // use keys from your $groups array
    ];

    public function mount(Question $question): void
    {
        $this->groups = [1,2,3];
        $this->question = $question;

        if ($this->question->exists) {
            $this->editing = true;
            $this->selectedGroup = $this->question->class_ids;
            $this->level = $this->question->level;

            foreach ($this->question->options as $option) {
                $this->options[] = [
                    'id' => $option->id,
                    'text' => $option->text,
                    'correct' => $option->correct,
                ];
            }
        }
    }
    public function save()
    {
        $this->validate();
         // Count how many options have non-empty text
        $filledOptions = collect($this->options)->filter(function ($option) {
            return !empty($option['text']);
        });

        if ($filledOptions->count() < 2) {
            $this->addError('options_text', 'At least 2 options must be filled.');
            return;
        }
        // custom validation for at least one correct option
        $correctOptionExists = collect($this->options)->contains(function ($option) {
            return isset($option['correct']) && $option['correct'];
        });

        if (!$correctOptionExists) {
            $this->addError('options_correct', 'Please mark at least one option as correct.');
            return;
        }
        // Handle image upload
        // if ($this->image) {
        //     $imageName = time() . '.' . $this->image->getClientOriginalExtension();
        //     $imagePath = $this->image->storeAs('question', $imageName, 'public');
        //     $this->question->image_path =  $imagePath;
        // }

        $classIds = $this->selectedGroup;
        $this->question->class_ids = $classIds;
        $this->question->marks = 1;
        $this->question->level = $this->level;
        $this->question->save();

        // --- Handle options update ---
        $existingOptionIds = $this->question->options()->pluck('id')->toArray();
        $submittedOptionIds = [];
        ksort($this->options);
        foreach ($this->options as $optionData) {
            if(trim($optionData['text']) != '' && $optionData['text'] !=null)
            {
                if (!empty($optionData['id']) && in_array($optionData['id'], $existingOptionIds)) {
                    // Update existing option
                    $option = $this->question->options()->find($optionData['id']);
                    $option->update($optionData);
                    $submittedOptionIds[] = $option->id;
                } else {
                    // Create new option
                    $newOption = $this->question->options()->create($optionData);
                    $submittedOptionIds[] = $newOption->id;
                }
            }
        }

        // Delete removed options (those not present in submitted data)
        $this->question->options()
            ->whereNotIn('id', $submittedOptionIds)
            ->delete();

        return redirect()->route('questions');
    }
    public function render(): View
    {
        return view('livewire.question.question-form');
    }
}
