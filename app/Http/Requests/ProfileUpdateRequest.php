<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            //'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'institute' => ['string', 'max:255'],
            'college' => ['string', 'max:255'],
            'phone' => ['string', 'max:255','min:10'],
            'session_year' => ['string', 'max:255'],
            'streams' => ['string', 'max:255'],
            'other_stream'=>['nullable','string', 'max:255'],
        ];
    }
}
