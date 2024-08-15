<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateSupplierRequest",
 *     type="object",
 *     title="Update Supplier Request",
 *     description="Request payload for updating an existing supplier",
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the supplier",
 *         example="Acme Corp",
 *         maxLength=100,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="Type of supplier, either 'Pessoa Física' or 'Pessoa Jurídica'",
 *         enum={"Pessoa Física", "Pessoa Jurídica"},
 *         example="Pessoa Jurídica",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="cnpj",
 *         type="string",
 *         description="CNPJ number",
 *         example="12345678000195",
 *         maxLength=14,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="cpf",
 *         type="string",
 *         description="CPF number",
 *         example="12345678901",
 *         maxLength=11,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="company_industry",
 *         type="string",
 *         description="Industry sector of the company",
 *         example="Technology",
 *         maxLength=100,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="Phone number of the supplier",
 *         example="11987654321",
 *         maxLength=11,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         description="Address of the supplier",
 *         example="Rua Exemplo",
 *         maxLength=100,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="cep",
 *         type="string",
 *         description="Postal code of the supplier's address",
 *         example="12345678",
 *         maxLength=8,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="number",
 *         type="string",
 *         description="House or building number of the supplier's address",
 *         example="123",
 *         maxLength=5,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="complement",
 *         type="string",
 *         description="Address complement, such as apartment number",
 *         example="Apto 101",
 *         maxLength=50,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="neighborhood",
 *         type="string",
 *         description="Neighborhood of the supplier's address",
 *         example="Centro",
 *         maxLength=50,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string",
 *         description="City of the supplier's address",
 *         example="São Paulo",
 *         maxLength=50,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="state",
 *         type="string",
 *         description="State of the supplier's address",
 *         example="SP",
 *         enum={"AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RJ", "RN", "RS", "RO", "RR", "SC", "SP", "SE", "TO"},
 *         nullable=true
 *     )
 * )
 */

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
            'name' => 'string|max:100|not_regex:/^\d+$/i|nullable',
            'type' => [Rule::in(['Pessoa Física', 'Pessoa Jurídica']), 'nullable'],
            'cnpj' => 'integer|digits:14|nullable',
            'cpf' => ['integer', 'digits:11', 'nullable'],
            'company_industry' => 'string|max:100|nullable',
            'phone' => 'integer|digits:11|nullable',
            'address' => 'string|max:100|nullable',
            'cep' => 'integer|digits:8|nullable',
            'number' => 'string|alphanum|max:5|nullable',
            'complement' => 'string|max:50|nullable',
            'neighborhood' => 'string|max:50|nullable',
            'city' => 'string|max:50|nullable',
            'state' => ['string', 'nullable', Rule::in(
                [
                    'AC',
                    'AL',
                    'AP',
                    'AM',
                    'BA',
                    'CE',
                    'DF',
                    'ES',
                    'GO',
                    'MA',
                    'MT',
                    'MS',
                    'MG',
                    'PA',
                    'PB',
                    'PR',
                    'PE',
                    'PI',
                    'RJ',
                    'RN',
                    'RS',
                    'RO',
                    'RR',
                    'SC',
                    'SP',
                    'SE',
                    'TO',
                ]
            )],
        ];
    }
}
