<?php

namespace App\Rules;

use App\Support\Document\Cnpj;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CnpjRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
       if(! (new Cnpj($value))->isValid()){
           $fail("The field $attribute is not a valid CNPJ");
       }
    }

}
