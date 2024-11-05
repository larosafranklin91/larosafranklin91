<?php

namespace App\Actions;

use App\Exceptions\NotFoundException;
use App\Http\Integrations\BrasilApi\BrasilAPI;
use App\Support\Document\Cnpj;

class SearchCompanyByDocument
{
    public function __construct(
        private readonly BrasilAPI $api,
        private readonly Cnpj      $documentValidator
    )
    {
    }

    public function handle(string $document)
    {
        if ($this->documentValidator->check($document)->isInvalid()) {
            throw new NotFoundException('Company Not Found');
        }

        return $this->api->cnpj($document);
    }

}
