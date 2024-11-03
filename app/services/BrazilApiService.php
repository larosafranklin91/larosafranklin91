<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BrazilApiService
{
    private const CACHE_TTL = 60 * 60 * 24; // 24 hours in seconds

    public static function getBusinessByCnpj(string $cnpj)
    {
        if (!self::isValidCnpj($cnpj)) {
            throw new \InvalidArgumentException("CNPJ inválido.");
        }

        $cachedData = Cache::get("cnpj_{$cnpj}");
        if ($cachedData) {
            return $cachedData; // Retorna os dados cacheados se existirem
        }

        $business = self::getBusinessFromBrazilAPIByCnpj($cnpj);
        Cache::put("cnpj_{$cnpj}", $business, self::CACHE_TTL);

        return $business;
    }

    protected static function getBusinessFromBrazilAPIByCnpj(string $cnpj)
    {
        $client = new Client(['base_uri' => 'https://brasilapi.com.br/api/']);

        try {
            $response = $client->get("cnpj/v1/{$cnpj}");
            $data = json_decode($response->getBody()->getContents());

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Erro ao decodificar JSON.");
            }

            return $data;
        } catch (RequestException $e) {
            Log::error("Erro ao buscar dados do CNPJ: {$e->getMessage()}");
            throw new \Exception("Não foi possível acessar a API do Brasil.");
        } catch (\Exception $e) {
            Log::error("Erro geral: {$e->getMessage()}");
            throw $e;
        }
    }

    private static function isValidCnpj(string $cnpj): bool
    {
        return preg_match('/^\d{14}$/', $cnpj) === 1;
    }
}
