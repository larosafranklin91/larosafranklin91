<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'supplier' => [
                'required',
                'array',
            ],
            'supplier.fantasy_name' => 'required|string|max:255',
            'supplier.company_name' => 'required|string|max:255',
            'supplier.cnpj' => 'required|string|size:14', 
            'supplier.email' => 'required|email|max:255',
            'supplier.phone' => 'required|string|max:15',
            'supplier.responsible' => 'required|string|max:255',
            'address' => [
                'required',
                'array',
            ],
            'address.cep' => 'required|string|max:10', 
            'address.state' => 'required|string|max:2', 
            'address.city' => 'required|string|max:100',
            'address.district' => 'required|string|max:100',
            'address.address' => 'required|string|max:255',
            'address.number' => 'required|integer',
            'address.complement' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'supplier.required' => 'The supplier information is required.',
            'supplier.array' => 'The supplier must be an array.',
            
            'supplier.fantasy_name.required' => 'The fantasy name is required.',
            'supplier.fantasy_name.string' => 'The fantasy name must be a string.',
            'supplier.fantasy_name.max' => 'The fantasy name may not be greater than 255 characters.',
            
            'supplier.company_name.required' => 'The company name is required.',
            'supplier.company_name.string' => 'The company name must be a string.',
            'supplier.company_name.max' => 'The company name may not be greater than 255 characters.',
            
            'supplier.cnpj.required' => 'The CNPJ is required.',
            'supplier.cnpj.string' => 'The CNPJ must be a string.',
            'supplier.cnpj.size' => 'The CNPJ must be exactly 14 characters.',
            
            'supplier.email.required' => 'The email is required.',
            'supplier.email.email' => 'The email must be a valid email address.',
            'supplier.email.max' => 'The email may not be greater than 255 characters.',
            
            'supplier.phone.required' => 'The phone number is required.',
            'supplier.phone.string' => 'The phone number must be a string.',
            'supplier.phone.max' => 'The phone number may not be greater than 15 characters.',
            
            'supplier.responsible.required' => 'The responsible person is required.',
            'supplier.responsible.string' => 'The responsible person must be a string.',
            'supplier.responsible.max' => 'The responsible person may not be greater than 255 characters.',
            
            'address.required' => 'The address information is required.',
            'address.array' => 'The address must be an array.',
            
            'address.cep.required' => 'The CEP is required.',
            'address.cep.string' => 'The CEP must be a string.',
            'address.cep.max' => 'The CEP may not be greater than 10 characters.',
            
            'address.state.required' => 'The state is required.',
            'address.state.string' => 'The state must be a string.',
            'address.state.max' => 'The state may not be greater than 2 characters.',
            
            'address.city.required' => 'The city is required.',
            'address.city.string' => 'The city must be a string.',
            'address.city.max' => 'The city may not be greater than 100 characters.',
            
            'address.district.required' => 'The district is required.',
            'address.district.string' => 'The district must be a string.',
            'address.district.max' => 'The district may not be greater than 100 characters.',
            
            'address.address.required' => 'The address is required.',
            'address.address.string' => 'The address must be a string.',
            'address.address.max' => 'The address may not be greater than 255 characters.',
            
            'address.number.required' => 'The address number is required.',
            
            'address.complement.string' => 'The complement must be a string.',
            'address.complement.max' => 'The complement may not be greater than 255 characters.',
        ];
    }
}
