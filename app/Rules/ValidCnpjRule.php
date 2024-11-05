<?php

namespace App\Rules;

use App\Http\Integrations\BrasilApi\BrasilAPI;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCnpjRule implements ValidationRule
{

    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $this->companyIsActive($value)) {
            $fail("Esta empresa não é válida");
        }
    }

    private function companyIsActive($cnpj):bool
    {
        return (new BrasilAPI())->cnpj($cnpj)?->isActive();
    }
}
