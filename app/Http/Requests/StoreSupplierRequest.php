<?php

namespace App\Http\Requests;

use App\Rules\Cnpj;
use App\Rules\Cpf;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreSupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $identityDocumentLength = strlen($this->identity_document);

        if ($identityDocumentLength === 11) {
            $this->merge(['type_person' => 'F']);
        } elseif ($identityDocumentLength === 14) {
            $this->merge(['type_person' => 'J']);
        } else {
            throw new HttpResponseException(response()->json([
                'message' => 'O número de documento deve ter 11 ou 14 caracteres (CPF ou CNPJ).',
            ], 422));
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'supplier_name' => ['required', 'string', 'max:255'],
            'identity_document' => [
                'required',
                'unique:suppliers',
                Rule::when($this->type_person === 'F', new Cpf()),
                Rule::when($this->type_person === 'J', new Cnpj()),
            ],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:suppliers'],
            'supply_cep' => ['required', 'string', 'regex:/^(?!.*(\d)(\1{7})).{8}$/'],
            'supply_address_complement' => ['required', 'string', 'max:20'],
            'phone' => ['required', 'string', 'digits:11'],
            'birthdate' => [
                'date',
                Rule::when($this->type_person === 'F', 'required')
            ],
            'type_person' => ['required', 'string', Rule::in(['F', 'J'])],
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
