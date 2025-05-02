<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use App\Models\Classess;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class QuestionForm extends Component
{
    use WithFileUploads;

    public Question $question;
    public array $options = [];
    public bool $editing = false;
    public $image;  // Updated to be just 'image' to handle file upload

    public array $selectedClassIds = [];
    public $classes = [];

    protected $rules = [
        'question.text' => 'required|string',
        'image' => 'nullable|image|max:1024', // Validate image file
        'question.code_snippet' => 'nullable|string',
        'question.answer_explanation' => 'nullable|string',
        'question.more_info_link' => 'nullable',
        'options' => 'required|array',
        'options.*.text' => 'required|string',
        'selectedClassIds' => 'required|array|min:1',
        'selectedClassIds.*' => 'exists:classess,id',
    ];

    public function mount(Question $question): void
    {
        $this->classes = Classess::all();
        $this->question = $question;

        if ($this->question->exists) {
            $this->editing = true;
            $this->selectedClassIds = $this->question->class_ids ? json_decode($this->question->class_ids, true) : [];
            foreach ($this->question->options as $option) {
                $this->options[] = [
                    'id' => $option->id,
                    'text' => $option->text,
                    'correct' => $option->correct,
                ];
            }
        }
    }

    // public function addOption(): void
    // {
    //     if (count($this->options) < 4) {
    //         $this->options[] = [
    //             'text' => '',
    //             'correct' => false
    //         ];
    //     }
    // }

    // public function removeOption(int $index): void
    // {
    //     unset($this->options[$index]);
    //     $this->options = array_values(($this->options));
    // }

    public function save()
    {
        $this->validate();

        if ($this->image) {
            $imageName = time() . '.' . $this->image->getClientOriginalExtension();
            $imagePath = $this->image->storeAs('byd', $imageName, 'public');

            $this->question->image_path =  $imagePath;
        }
        $this->question->class_ids = json_encode($this->selectedClassIds);
        $this->question->save();

        $this->question->options()->delete();

        foreach ($this->options as $option) {
            $this->question->options()->create($option);
        }

        return redirect()->route('questions');
    }


    public function render(): View
    {
        return view('livewire.question.question-form');
    }
}
