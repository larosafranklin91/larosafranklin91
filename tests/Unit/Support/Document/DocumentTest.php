<?php

use App\Support\Document\Document;
use App\Support\Document\Cnpj;

it('returns a Cnpj instance', function () {
    $document = new Document();
    $cnpj = $document->cnpj();

    expect($cnpj)->toBeInstanceOf(Cnpj::class);
});
