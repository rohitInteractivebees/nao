<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;

class StudentEditForm extends Component
{
    public User $user;

    public $userId;
    public $school_name;
    public $school_name_text;
    public $class;
    public $session_year;
    public $name;
    public $parent_name;
    public $country_code;
    public $phone;
    public $password;

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],

            'phone' => [
                'nullable',
                'string',
                'regex:/^\d{7,12}$/',
                Rule::unique('users', 'phone')->ignore($this->userId)
            ],
            'session_year' => ['required', 'string'],
            'parent_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],

            'school_name' => ['required'],
            'class' => ['required', 'integer', 'exists:classess,id'],

        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Student Name field is required.',
            'name.regex' => 'Student Name should only contain letters and spaces.',

            'phone.regex' => 'Parent Phone number must be between 7 and 12 digits.',
            'phone.unique' => 'Parent Phone number is already taken.',

            'parent_name.required' => 'Parent name is required.',
            'parent_name.regex' => 'Parent name should only contain letters and spaces.',

            'class.required' => 'Class is required.',
            'class.exists' => 'Class not exists.',
        ];
    }


    public function mount($id)
    {
        $this->user = User::findOrFail($id);
        $this->userId = $this->user->id;
        $this->school_name = $this->user->institute;
        $this->school_name_text = $this->user->school_name;
        $this->class = json_decode($this->user->class,true)[0];
        $this->session_year = $this->user->session_year;
        $this->name = $this->user->name;
        $this->parent_name = $this->user->parent_name;
        $this->country_code = $this->user->country_code;
        $this->phone = $this->user->phone;

    }
    public function save()
    {
        $this->validate($this->rules(), $this->messages());
        if (is_array($this->class)) {
            $encodedClassname = json_encode($this->class);
        } else {
            $encodedClassname = json_encode([(string) $this->class]);
        }
        $this->user->name = $this->name;
        $this->user->country_code = $this->country_code;
        $this->user->phone = $this->phone;
        $this->user->parent_name = $this->parent_name;
        $this->user->session_year = $this->session_year;
        $this->user->class = $encodedClassname;
        $this->user->institute = $this->school_name;
        if($this->school_name != 'Other')
        {
            $this->user->school_name = null;
        }
        if(trim($this->password) != '' && trim($this->password) != null)
        {
            $this->user->password = Hash::make($this->password);
        }
        $this->user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function render(): View
    {
        return view('livewire.admin.edit-student-profile');
    }



}
