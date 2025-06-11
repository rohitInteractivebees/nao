<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Instute;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;

class SchoolEditForm extends Component
{
    public User $user;
    public Instute $instute;

    public $userId;
    public $instuteId;
    public $name;
    public $country_code;
    public $phone;
    public $parent_name;
    public $spoc_country_code;
    public $spoc_mobile;
    public $school_name;



    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],

            'phone' => [
                'required',
                'string',
                'regex:/^\d{7,12}$/',
                Rule::unique('users', 'phone')->ignore($this->userId),
                'different:spoc_mobile'
            ],

            'parent_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],

            'spoc_mobile' => [
                'required',
                'string',
                'regex:/^\d{7,12}$/',
                'different:principal_mobile'
            ],

            'school_name' => [
                'required',
                'string',
                Rule::unique('instutes', 'name')->ignore($this->instuteId)
            ],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Principal Name field is required.',
            'name.regex' => 'Principal Name should only contain letters and spaces.',

            'phone.required' => 'Principal Phone number is required.',
            'phone.regex' => 'Principal Phone number must be between 7 and 12 digits.',
            'phone.unique' => 'Principal Phone number is already taken.',
            'phone.different' => 'Principal Phone number must be different from SPOC mobile.',

            'parent_name.required' => 'Spoc name is required.',
            'parent_name.regex' => 'Spoc name should only contain letters and spaces.',

            'spoc_mobile.required' => 'Spoc mobile is required.',
            'spoc_mobile.regex' => 'Spoc mobile must be between 7 and 12 digits.',
            'spoc_mobile.different' => 'Spoc mobile must be different from Principal mobile.',

            'school_name.required' => 'School name is required.',
            'school_name.unique' => 'School name already exists.',
        ];
    }


    public function mount($id)
    {
        $this->user = User::findOrFail($id);
        $this->userId = $this->user->id;
        $this->name = $this->user->name;
        $this->country_code = $this->user->country_code;
        $this->phone = $this->user->phone;
        $this->parent_name = $this->user->parent_name;
        $this->spoc_country_code = $this->user->spoc_country_code;
        $this->spoc_mobile = $this->user->spoc_mobile;

        $this->instute = Instute::findOrFail($this->user->institute);
        $this->school_name = $this->instute->name;
        $this->instuteId = $this->instute->id;
    }
    public function save()
    {
        $this->validate($this->rules(), $this->messages());
        $this->user->name = $this->name;
        $this->user->country_code = $this->country_code;
        $this->user->phone = $this->phone;
        $this->user->parent_name = $this->parent_name;
        $this->user->spoc_country_code = $this->spoc_country_code;
        $this->user->spoc_mobile = $this->spoc_mobile;
        $this->user->save();
        $this->instute->name = $this->school_name;
        $this->instute->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function render(): View
    {
        return view('livewire.admin.edit-school-profile');
    }



}
