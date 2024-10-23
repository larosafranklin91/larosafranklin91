<?php

function generateCNPJ() {
    $cnpj = '';
    for ($i = 0; $i < 12; $i++) {
        $cnpj .= rand(0, 9);
    }

    // Cálculo dos dígitos verificadores
    $cnpj .= calculateCNPJCheckDigits($cnpj);
    return $cnpj;
}

function calculateCNPJCheckDigits($cnpj) {
    return '00';
}