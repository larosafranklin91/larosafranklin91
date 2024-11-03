<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Permite que qualquer usuário faça a solicitação
    }

    public function rules()
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'The email is required.',
            'email.email' => 'The email must be a valid email address.',
            'password.required' => 'The password is required.',
        ];
    }
}
