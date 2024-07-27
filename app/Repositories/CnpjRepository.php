<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use App\Interfaces\CnpjInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;

class CnpjRepository implements CnpjInterface
{
    protected $apiUrl = 'https://brasilapi.com.br/api/cnpj/v1/';

    public function getCnpjData($cnpj)
    {
        try {
            $response = Http::get($this->apiUrl . $cnpj);
            if ($response->successful()) {
                return $response->json();
            }
            Log::warning('CNPJ não encontrado ou resposta não bem-sucedida', [
                'cnpj' => $cnpj,
                'status' => $response->status()
            ]);
            return response()->json(['error' => 'Dados do CNPJ não encontrados.'], 404);

        } catch (RequestException $exception) {
            Log::error('Erro ao buscar dados do CNPJ: ' . $exception->getMessage(), [
                'cnpj' => $cnpj,
                'exception' => $exception
            ]);
            return response()->json(['error' => 'Ocorreu um erro ao processar sua solicitação. Por favor, tente novamente mais tarde.'], 500);
        } catch (\Exception $exception) {
            Log::error('Erro inesperado ao buscar dados do CNPJ: ' . $exception->getMessage(), [
                'cnpj' => $cnpj,
                'exception' => $exception
            ]);
            return response()->json(['error' => 'Ocorreu um erro inesperado.'], 500);
        }
    }
}
