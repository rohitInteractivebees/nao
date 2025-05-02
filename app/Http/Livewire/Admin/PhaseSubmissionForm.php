<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ProjectSubmissionsPhase2;
use Illuminate\Support\Facades\Storage;

class PhaseSubmissionForm extends Component
{
    use WithFileUploads;

    public $teamId;
    public $file;
    public $submissions;
    public $selectedSubmission;
    public $fileName;
    public $fileType;
    public $fileSize;

    protected $rules = [
        'file' => 'required|file|max:10240|mimetypes:application/pdf,application/vnd.ms-powerpoint,video/quicktime,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    public function mount()
    {
        $this->submissions = ProjectSubmissionsPhase2::all();
    }

    public function updatedFile()
    {
        $this->validate();
        $this->fileType = strtoupper($this->file->extension());
        $this->fileSize = $this->file->getSize();
    }

    public function save()
    {
        $this->validate();

        $filePath = $this->file->store('submissions', 'public');

        ProjectSubmissionsPhase2::create([
            'teamID' => $this->teamId,
            'FileName' => $this->file->getClientOriginalName(),
            'FilePath' => $filePath,
            'FileType' => $this->fileType,
            'FileSize' => $this->fileSize,
        ]);

        session()->flash('message', 'File has been successfully uploaded.');

        $this->reset(['file']);
        $this->submissions = ProjectSubmissionsPhase2::all(); // Refresh the list of submissions
    }

    public function edit($id)
    {
        $submission = ProjectSubmissionsPhase2::findOrFail($id);
        $this->selectedSubmission = $submission;
        $this->fileName = $submission->FileName;
        $this->fileType = $submission->FileType;
    }

    public function update()
    {
        $submission = ProjectSubmissionsPhase2::findOrFail($this->selectedSubmission->SubmissionID);

        if ($this->file) {
            $this->validate();

            // Delete the old file
            Storage::disk('public')->delete($submission->FilePath);

            // Upload new file
            $filePath = $this->file->store('submissions', 'public');
            $submission->update([
                'FileName' => $this->file->getClientOriginalName(),
                'FilePath' => $filePath,
                'FileType' => strtoupper($this->file->extension()),
                'FileSize' => $this->file->getSize(),
            ]);
        } else {
            $submission->update([
                'FileName' => $this->fileName,
                'FileType' => $this->fileType,
            ]);
        }

        session()->flash('message', 'Submission has been successfully updated.');

        $this->reset(['file', 'selectedSubmission']);
        $this->submissions = ProjectSubmissionsPhase2::all(); // Refresh the list of submissions
    }

    public function delete($id)
    {
        $submission = ProjectSubmissionsPhase2::findOrFail($id);

        // Delete the file from storage
        Storage::disk('public')->delete($submission->FilePath);

        $submission->delete();

        session()->flash('message', 'Submission has been successfully deleted.');

        $this->submissions = ProjectSubmissionsPhase2::all(); // Refresh the list of submissions
    }

    public function render()
    {
        return view('livewire.admin.phase-submission-form-2');
    }
}
