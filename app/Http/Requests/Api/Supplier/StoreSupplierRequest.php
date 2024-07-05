<?php

namespace App\Http\Requests\Api\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
            'name' => 'required|string',
            'company_name' => 'sometimes|string',
            'email' => 'required|email|',
            'phone' => 'sometimes|string',
            'address' => 'sometimes|string',
            'city' => 'sometimes|string',
            'state' => 'sometimes|string',
            'zip' => 'sometimes|string|max:8',
            'cpf_cnpj' => 'required|string|unique:suppliers,cpf_cnpj',
        ];

    }

   
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'company_name.string' => 'Company name must be a string',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email',
            'phone.required' => 'Phone is required',
            'address.required' => 'Address is required',
            'city.required' => 'City is required',
            'state.required' => 'State is required',
            'zip.required' => 'Zip is required',
            'zip.max' => 'Zip must have a maximum of 8 characters',
            'cpf_cnpj.required' => 'CPF/CNPJ is required',
            'cpf_cnpj.unique' => 'CPF/CNPJ must be unique',
        ];
    }
}
