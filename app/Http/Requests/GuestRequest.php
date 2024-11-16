<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GuestRequest extends FormRequest
{
    public function rules(): array
    {
        $countries = array_values(config('phone_prefixes.prefixes'));

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => [
                'required',
                'string',
                'regex:/^\+\d{1,3}\d{10}$/',
                Rule::unique('guests')->ignore($this->guest),
            ],
            'email' => [
                'nullable',
                'email',
                Rule::unique('guests')->ignore($this->guest),
            ],
            'country' => ['nullable', 'string', 'max:255', Rule::in($countries)],
        ];
    }
}
