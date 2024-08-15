<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="ListSuppliersRequest",
 *     type="object",
 *     title="List Suppliers Request",
 *     description="Request payload for listing suppliers with optional filters and sorting",
 *     @OA\Property(
 *         property="filter_by",
 *         type="string",
 *         description="Field to filter the suppliers by",
 *         enum={
 *             "name",
 *             "type",
 *             "cnpj",
 *             "cpf",
 *             "company_industry",
 *             "phone",
 *             "address",
 *             "cep",
 *             "number",
 *             "complement",
 *             "neighborhood",
 *             "city",
 *             "state"
 *         },
 *         example="name",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="filter_value",
 *         type="string",
 *         description="Value to filter the selected field by",
 *         example="Acme Corp",
 *         minLength=2,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="sort_by",
 *         type="string",
 *         description="Field to sort the suppliers by",
 *         enum={
 *             "name",
 *             "type",
 *             "cnpj",
 *             "cpf",
 *             "company_industry",
 *             "phone",
 *             "address",
 *             "cep",
 *             "number",
 *             "complement",
 *             "neighborhood",
 *             "city",
 *             "state"
 *         },
 *         example="name",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="direction",
 *         type="string",
 *         description="Sort direction, either ascending (asc) or descending (desc)",
 *         enum={"asc", "desc"},
 *         example="asc",
 *         nullable=true
 *     )
 * )
 */

class ListSuppliersRequest extends FormRequest
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
            'filter_by' => [
                Rule::in([
                    'name',
                    'type',
                    'cnpj',
                    'cpf',
                    'company_industry',
                    'phone',
                    'address',
                    'cep',
                    'number',
                    'complement',
                    'neighborhood',
                    'city',
                    'state',
                ])
            ],
            'filter_value' => 'string|min:2',
            'sort_by' => [
                Rule::in([
                    'name',
                    'type',
                    'cnpj',
                    'cpf',
                    'company_industry',
                    'phone',
                    'address',
                    'cep',
                    'number',
                    'complement',
                    'neighborhood',
                    'city',
                    'state',
                ])
            ],
            'direction' => Rule::in(['asc', 'desc']),
        ];
    }
}
