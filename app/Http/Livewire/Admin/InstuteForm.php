<?php

namespace App\Http\Livewire\Admin;

use App\Models\Instute;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class InstuteForm extends Component
{
    public Instute $instute;
    public bool $editing = false;

    protected $rules = [
        'instute.name' => 'required|string|max:255',
    ];

    public function mount(Instute $instute)
    {
        $this->instute = $instute;

        if ($this->instute->exists) {
            $this->editing = true;
        }
    }

    public function save()
    {
        $this->validate();

        $this->instute->save();

        session()->flash('message', $this->editing ? 'Institute updated successfully.' : 'Institute created successfully.');

        return redirect()->route('institute');
    }

    public function render(): View
    {
        return view('livewire.admin.instute-form');
    }
}
