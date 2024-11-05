<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'street' =>[$this->requirable(),'string'],
            'city' =>[$this->requirable(),'string'],
            'state' =>[$this->requirable(),'string'],
            'zip_code' =>[$this->requirable(),'string'],
            'complement' =>['nullable','string'],
            'neighborhood' =>[$this->requirable(),'string'],
            'number' =>[$this->requirable(),'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'zip_code' => preg_replace('/[^0-9]/', '', $this->zip_code),
        ]);
    }
}
