<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NameFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstName' => ['required', 'min:2'],
            'lastName'  => ['required', 'min:2'],
            'email'     => ['required', 'email'],
        ];
    }

    public function messages(): array
    {
        return [
            'firstName.required' => 'Voornaam is verplicht.',
            'firstName.min'      => 'Voornaam moet minstens 2 tekens bevatten.',
            'lastName.required'  => 'Achternaam is verplicht.',
            'lastName.min'       => 'Achternaam moet minstens 2 tekens bevatten.',
            'email.required'     => 'E-mailadres is verplicht.',
            'email.email'        => 'Ongeldig e-mailadres.',
        ];
    }
}




