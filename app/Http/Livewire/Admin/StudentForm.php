<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Instute;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail; // Assuming you have a WelcomeEmail class for sending emails

class StudentForm extends Component
{
    public $name;
    public $email;
    public $phone;
    public $password;
    public $streams;
    public $session_year;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'phone' => 'nullable|string|max:10|min:10',
        'password' => 'required|string|min:8',
        'streams' => 'nullable|string|max:255',
        'session_year' => 'nullable|string|max:255',
    ];

    public function save()
    {
        $this->validate();

        $instituteId = auth()->user()->institute;

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'streams' => $this->streams,
            'session_year'=>$this->session_year,
            'institute' => $instituteId,
            'is_verified' => 1,
        ]);

        Mail::to($this->email)->send(new WelcomeEmail($this->name, $this->email, $this->password));

        session()->flash('message', 'User has been successfully registered and email sent.');

        return redirect()->route('student');
    }

    public function render()
    {
        return view('livewire.admin.student-form');
    }
}
