<?php

namespace App\Http\Integrations\BrasilApi;

use App\Exceptions\NotFoundException;
use App\Http\Integrations\BrasilApi\DTO\CompanyDTO;
use App\Http\Integrations\BrasilApi\Requests\SearchCNPJ;
use Saloon\Http\Connector;

class BrasilAPI
{
    public function __construct(
        private Connector $connector = new BrasilApiConnector()
    )
    {
    }

    public function cnpj(string $cnpj): CompanyDTO
    {
        $response = $this->connector->send(
            new SearchCNPJ($cnpj)
        );

        $response->onError(function ($response)use ($cnpj) {
           throw new NotFoundException("Company with CNPJ {$cnpj} was not found on Brazilian Federal Revenue Office database");
        });

        return $response->dto();
    }
}
