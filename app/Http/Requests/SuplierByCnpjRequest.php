<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuplierByCnpjRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Permite que qualquer usuário faça a solicitação
    }

    public function rules()
    {
        return [
            'cnpj' => 'required|string|size:14', 
        ];
    }

    public function messages()
    {
        return [
            'cnpj.required' => 'The CNPJ is required.',
            'cnpj.string' => 'The CNPJ must be a string.',
            'cnpj.size' => 'The CNPJ must be exactly 14 characters.',
        ];
    }
}
