<?php

namespace App\Support\Document;

class Cnpj
{

    private bool $isValid = true;
    private ?string $cnpj;


    public function check($document): self
    {
        $this->cnpj = $document;
        $this->validate();

        return $this;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function isInvalid(): bool
    {
        return !$this->isValid();
    }

    public function validate(): void
    {
        $cnpj = preg_replace('/[^0-9]/', '', $this->cnpj);

        if (!$this->validateCnpjFormat($cnpj)) {
            $this->isValid = false;
            return;
        }

        if (!$this->validateFirstDigit($cnpj)) {
            $this->isValid = false;
            return;
        }

        if (!$this->validateSecondDigit($cnpj)) {
            $this->isValid = false;
        }
    }

    private function validateCnpjFormat(string $cnpj)
    {
        if (strlen($cnpj) != 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        return true;
    }

    private function validateFirstDigit(string $cnpj): bool
    {
        for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++) {
            $sum += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $module = $sum % 11;

        return $cnpj[12] == ($module < 2 ? 0 : 11 - $module);
    }

    private function validateSecondDigit(string $cnpj): bool
    {
        for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++) {
            $sum += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $module = $sum % 11;

        return $cnpj[13] == ($module < 2 ? 0 : 11 - $module);
    }
}
