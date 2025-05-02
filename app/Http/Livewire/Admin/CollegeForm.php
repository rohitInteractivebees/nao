<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use App\Mail\InstituteLoginMail;
use Illuminate\Support\Facades\Mail;

class CollegeForm extends Component
{
    public $name;
    public $email;
    public $password;
    public $institute;
    public $userId;

    protected $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email',
        'password' => 'required|string|min:6',
        'institute' => 'required',
    ];

   

    public function mount(User $user)
    {
        if ($user) {
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->institute = $user->institute;
            // Do not set password here as it should not be revealed.
        }
    }


    public function save()
    {
       // dd($this->userId);
        $this->validate();

        if ($this->userId) {
            $user = User::find($this->userId);
            dd($user);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password ? Hash::make($this->password) : $user->password,
                'institute' => $this->institute,
            ]);
        } else {
           
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'is_college' => 1,
                'institute' => $this->institute,
                'is_verified' => 1,
            ]);
           
        }
        Mail::to($this->email)->send(new InstituteLoginMail($this->name,$this->email,$this->password));
       // session()->flash('message', 'Saved.');
        return redirect()->route('institute_login');
    }

    public function delete()
    {
        if ($this->userId) {
            User::destroy($this->userId);
            session()->flash('message', 'User deleted.');
            return redirect()->route('college');
        }
    }

    public function render(): View
    {
        return view('livewire.admin.college-form');
    }

 
}
