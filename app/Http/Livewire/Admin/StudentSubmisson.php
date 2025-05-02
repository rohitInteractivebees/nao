<?php

namespace App\Http\Livewire\Admin;

use App\Models\Prototype;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StudentSubmisson extends Component
{
    use WithFileUploads;

    
    public $title;
    public $description;
    public $prototype_file;

    protected $rules = [
       
        'title' => 'required|string|max:50',
        'description' => 'required|string|max:500',
        'prototype_file' => 'required|file|mimes:mov,mp4,ppt,pptx,pdf|max:40960',

    ];


    
    public function mount(Prototype $prototype)
    {
        if ($prototype) {
            $this->prototype = $prototype->id;
            $this->title = $prototype->title;
            $this->description = $prototype->description;
            $this->prototype_file = $prototype->prototype_file;
            // Do not set password here as it should not be revealed.
        }
    }

    public function uploadPrototype()
    {
        $this->validate();

       
        $user = Auth::user();
        $prototype = Prototype::where('student_id', $user->id)->first();
        
        $fileName = time() . '.' . $this->prototype_file->getClientOriginalExtension();
        $filePath = $this->prototype_file->storeAs('prototype', $fileName, 'public');

        if ($prototype) {
            if ($prototype->edited == 1) {
                session()->flash('success', 'Prototype already edited once.');

                return redirect()->route('prototypelist');
            } else {
                $prototype->update([
                    'file' => $filePath,
                    'title' => $this->title,
                    'description' => $this->description,
                    'edited' => 1,
                ]);
            }
        } else {
            Prototype::create([
                'student_id' => $user->id,
                'college_id' => $user->institute,
                'file' => $filePath,
                'title' => $this->title,
                'description' => $this->description,
                
            ]);
        }

        session()->flash('success', 'Prototype uploaded successfully.');

        return redirect()->route('prototypelist');
    }

    // public function render()
    // {
    //     $user = Auth::user();
    //     $prototype = Prototype::where('student_id', $user->id)->first();

    //     return view('livewire.admin.student_submisson', compact('prototype'));
    // }
}
