<?php

use App\Support\Document\Cnpj;

it('validates a correct CNPJ', function () {
    $cnpj = new Cnpj();
    $cnpj->check('33.938.861/0001-74');

    expect($cnpj->isValid())->toBeTrue();
});

it('invalidates an incorrect CNPJ', function () {
    $cnpj = new Cnpj();
    $cnpj->check('00.000.000/0000-00');

    expect($cnpj->isInvalid())->toBeTrue();
});

it('invalidates a CNPJ with incorrect format', function () {
    $cnpj = new Cnpj();
    $cnpj->check('123');

    expect($cnpj->isInvalid())->toBeTrue();
});

it('validates the first digit of a CNPJ', function () {
    $cnpj = new Cnpj();
    $reflection = new ReflectionClass($cnpj);
    $method = $reflection->getMethod('validateFirstDigit');
    $method->setAccessible(true);

    expect($method->invokeArgs($cnpj, ['33938861000174']))->toBeTrue();
});

it('validates the second digit of a CNPJ', function () {
    $cnpj = new Cnpj();
    $reflection = new ReflectionClass($cnpj);
    $method = $reflection->getMethod('validateSecondDigit');
    $method->setAccessible(true);

    expect($method->invokeArgs($cnpj, ['33938861000174']))->toBeTrue();
});
