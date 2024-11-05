<?php

namespace App\Http\Integrations\BrasilApi;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class BrasilApiConnector extends Connector
{
    use AcceptsJson;

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
        return 'https://brasilapi.com.br/api';
    }

    /**
     * Default headers for every request
     */
    protected function defaultHeaders(): array
    {
        return [];
    }

    /**
     * Default HTTP client options
     */
    protected function defaultConfig(): array
    {
        return [];
    }
}
