<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Autorizar todos os usuários. Ajuste conforme necessário.
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'cnpj_cpf' => 'required|string|size:14|unique:suppliers,cnpj_cpf,' . $this->route('supplier'), // Atualiza ao editar
            'contact' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'cnpj_cpf.required' => 'The CNPJ/CPF field is required.',
            'cnpj_cpf.unique' => 'The CNPJ/CPF has already been taken.',
            // Adicione mensagens personalizadas conforme necessário
        ];
    }
}
