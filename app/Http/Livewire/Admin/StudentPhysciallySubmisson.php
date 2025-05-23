<?php

namespace App\Http\Livewire\Admin;

use App\Models\Physicaly;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;

class StudentPhysciallySubmisson extends Component
{
    use WithFileUploads;

    public $title3;
    public $description3;
    public $file3;
   // public $image3;
    public $physicaly;

    protected $rules = [
        'title3' => 'required|string|max:50',
        'description3' => 'required|string|max:500',
        'file' => 'required|file|mimes:mov,mp4,ppt,pptx,pdf|max:40960',
        //'image3' => 'required|file|mimes:pdf,jpg,png',
    ];

    public function mount(Physicaly $physicaly)
    {
        Log::info('Mount method called.');
        if ($physicaly) {
            Log::info('Physicaly model found.', ['physicaly' => $physicaly]);
            $this->physicaly = $physicaly;
            $this->title3 = $physicaly->title;
            $this->description3 = $physicaly->description;
            $this->file = $physicaly->file;
           // $this->image3 = $physicaly->image;
        }
    }

    public function save()
    {
        Log::info('Save method called.');
        $this->validate();

        $user = auth()->user();
        Log::info('Authenticated user.', ['user' => $user]);

        $physicaly = Physicaly::where('student_id', $user->id)->first();
        Log::info('Physicaly record fetched.', ['physicaly' => $physicaly]);

        $fileName = time() . '.' . $this->file->getClientOriginalExtension();
        $filePath = $this->file->storeAs('prototype', $fileName, 'public');
       // $imagePath = $this->image3->store('physcially', 'public');
        Log::info('Files stored.', ['filePath' => $filePath]);

        if ($physicaly) {
            if ($physicaly->edited) {
                Log::info('Physicaly already edited.');
                return redirect()->route('physciallylist');
            } else {
                Log::info('Updating existing Physicaly record.');
                $physicaly->update([
                    'file' => $filePath,
                   // 'image' => $imagePath,
                    'title' => $this->title3,
                    'description' => $this->description3,
                    'edited' => 1,
                ]);
            }
        } else {
            Log::info('Creating new Physicaly record.');
            Physicaly::create([
                'student_id' => $user->id,
                'college_id' => $user->institute,
                'file' => $filePath,
                //'image' => $imagePath,
                'title' => $this->title3,
                'description' => $this->description3,
            ]);
        }

        return redirect()->route('physciallylist');
    }

    // public function render(): View
    // {
    //     Log::info('Render method called.');
    //     return view('livewire.admin.student-physcially-submission');
    // }
}
