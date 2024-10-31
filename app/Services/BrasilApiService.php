<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class BrasilApiService
{
    public function fetchCNPJData(string $cnpj): array
    {
        $url = "https://brasilapi.com.br/api/cnpj/v1/{$cnpj}";

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json();

                return [
                    'nome_fantasia' => $data['nome_fantasia'] ?? null,
                    'razao_social' => $data['razao_social'] ?? null,
                    'endereco' => $data['logradouro'] ?? null,
                    'telefone' => $data['telefone'] ?? null,
                ];
            } else {
                return [];
            }
        } catch (\Exception $e) {
            Throw New Exception("Erro ao consultar CNPJ: " . $e->getMessage());
        }
    }

    public function fetchCEPData(string $cep): array
    {
        $url = "https://brasilapi.com.br/api/cep/v1/{$cep}";

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json();

                return [
                    $data
                ];
            }
        } catch (\Exception $e) {
            Throw New Exception("Erro ao consultar CEP: " . $e->getMessage());
        }
    }
}

?>
