<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;

class UpdateSupplierRequest extends FormRequest
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
            'identity_document' => ['prohibited'],
            'supplier_name' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255', 'unique:suppliers'],
            'supply_cep' => ['string', 'regex:/^(?!.*(\d)(\1{7})).{8}$/'],
            'supply_address_complement' => ['string', 'max:20'],
            'phone' => ['string', 'max:15'],
            'birthdate' => [
                'date',
                Rule::when($this->type_person === 'F', 'required')
            ],
            'type_person' => ['string', Rule::in(['F', 'J'])],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string' => 'O campo :attribute deve ser uma string.',
            'max' => 'O campo :attribute não pode ter mais que :max caracteres.',
            'prohibited' => 'O campo :attribute não pode ser atualizado.',
            'regex' => 'O campo :attribute deve ser um formato válido.',
            'unique' => 'O campo :attribute já está cadastrado.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Ocorreu um erro durante a validação dos dados. Consulte a documentação.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
