<?php

if (!function_exists('validarCPF')) {
    function validarCPF($cpf)
    {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/\D/', '', $cpf);

        // Verifica se o CPF tem 11 dígitos
        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Calcula os dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}

if (!function_exists('validarCNPJ')) {
    if (!function_exists('validarCNPJ')) {
        function validarCNPJ($cnpj)
        {
            // Remove caracteres não numéricos
            $cnpj = preg_replace('/\D/', '', $cnpj);
    
            // Verifica se o CNPJ tem 14 dígitos
            if (strlen($cnpj) != 14) {
                return false;
            }
    
            // Calcula os dígitos verificadores
            $peso1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
            $peso2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    
            // Primeiro dígito verificador
            for ($d = 0, $c = 0; $c < 12; $c++) {
                $d += $cnpj[$c] * $peso1[$c];
            }
            $d = ($d % 11) < 2 ? 0 : 11 - ($d % 11);
            if ($cnpj[12] != $d) {
                return false;
            }
    
            // Segundo dígito verificador
            for ($d = 0, $c = 0; $c < 13; $c++) {
                $d += $cnpj[$c] * $peso2[$c];
            }
            $d = ($d % 11) < 2 ? 0 : 11 - ($d % 11);
            if ($cnpj[13] != $d) {
                return false;
            }
    
            return true;
        }
    }
}

if (!function_exists('gerarCpfValido')) {  
    
    function gerarCpfValido() {
        $cpf = [];
        for ($i = 0; $i < 9; $i++) {
            $cpf[] = rand(0, 9);
        }
    
        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            $cpf[$t] = $d;
        }
    
        return implode('', $cpf);
    }
}