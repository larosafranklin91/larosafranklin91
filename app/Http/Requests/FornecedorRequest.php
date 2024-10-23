<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FornecedorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'documento' => 'required|cpf_cnpj|unique:fornecedores,documento',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'endereco' => 'nullable|string|max:255',
        ];
    }
}
