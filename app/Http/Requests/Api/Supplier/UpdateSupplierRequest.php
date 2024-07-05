<?php

namespace App\Http\Requests\Api\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string',
            'company_name' => 'sometimes|string',
            'email' => 'sometimes|email|',
            'phone' => 'sometimes|string',
            'address' => 'sometimes|string',
            'city' => 'sometimes|string',
            'state' => 'sometimes|string',
            'zip' => 'sometimes|string|max:8',
            'cpf_cnpj' => 'sometimes|string|unique:suppliers,cpf_cnpj',
        ];
    }

   
    public function messages(): array
    {
        return [
            'name.string' => 'Name must be a string',
            'company_name.string' => 'Company name must be a string',
            'email.email' => 'Email must be a valid email',
            'phone.string' => 'Phone must be a string',
            'address.string' => 'Address must be a string',
            'city.string' => 'City must be a string',
            'state.string' => 'State must be a string',
            'zip.string' => 'Zip must be a string',
            'zip.max' => 'Zip must have a maximum of 8 characters',
            'cpf_cnpj.string' => 'CPF/CNPJ must be a string',
            'cpf_cnpj.unique' => 'CPF/CNPJ must be unique',
        ];
    }
}
