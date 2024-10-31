<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Cnpj implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cnpj = preg_replace('/\D/', '', $value);

        // Verifica se o CNPJ possui 14 dígitos
        if (strlen($cnpj) != 14) {
            $fail("O CNPJ deve conter 14 dígitos."); // Mensagem de erro
            return;
        }

        if (!$this->validar_digito_verificador($cnpj, 12) || !$this->validar_digito_verificador($cnpj, 13)) {
            $fail("O CNPJ deve ser válido."); // Mensagem de erro
            return;
        }
    }

    function validar_digito_verificador($cnpj, $posicao)
    {
        $soma = 0;
        $peso = ($posicao == 12) ? 5 : 6;

        for ($i = 0; $i < $posicao; $i++) {
            $soma += $cnpj[$i] * $peso;
            $peso = ($peso == 2) ? 9 : $peso - 1;
        }

        $resto = $soma % 11;

        return $cnpj[$posicao] == ($resto < 2 ? 0 : 11 - $resto);
    }
}
