<?php

namespace App\Http\Requests;

use App\Rules\CnpjRule;
use App\Rules\ValidCnpjRule;
use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    use RequirableTrait;

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
            'company_name' => [$this->requirable(),],
            'trading_name' => [$this->requirable(),],
            'active' => [$this->requirable(), 'boolean'],
            // todo: validate on BrasilAPI if the CNPJ is valid
            'registration_number' => [
                $this->requirable(),
                new CnpjRule(),
                new ValidCnpjRule(),
                $this->validateRegistrationNumberUnique()
            ],
            'cnae' => [$this->requirable(),],
            'juridic_kind' => [$this->requirable(),],
            'parent_company' => [$this->requirable(), 'boolean'],
            'parent_id' => ['nullable', 'exists:suppliers,id'],
        ];
    }

    private function validateRegistrationNumberUnique(): string
    {
        $rule = 'unique:suppliers,registration_number';

        if ($this->isUpdating()) {
            $rule .= ",".$this->route('supplier');
        }

        return $rule;
    }
}
