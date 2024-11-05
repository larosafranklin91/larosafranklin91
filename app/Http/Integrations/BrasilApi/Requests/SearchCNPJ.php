<?php

namespace App\Http\Integrations\BrasilApi\Requests;

use App\Http\Integrations\BrasilApi\DTO\CompanyDTO;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class SearchCNPJ extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(
        private string $cnpj
    )
    {
        $this->cnpj = preg_replace('/[^0-9]/', '', $cnpj);
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return CompanyDTO::fromArray($response->json());
    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return "/cnpj/v1/$this->cnpj";
    }
}
