<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CnpjController extends Controller
{
    // Função para buscar informações de empresa pelo CNPJ
    public function buscarCnpj($cnpj)
    {
        // Valida o formato do CNPJ (com ou sem pontuação)
        $cnpj = preg_replace('/\D/', '', $cnpj); // Remove qualquer caractere não numérico
        
        if (strlen($cnpj) !== 14) {
            return response()->json(['error' => 'CNPJ inválido.'], 400);
        }

        $cacheKey = "cnpj_{$cnpj}";
        $dadosCnpj = Cache::get($cacheKey);

        if ($dadosCnpj) {
            return response()->json($dadosCnpj);
        }

        // Faz a requisição à BrasilAPI para buscar o CNPJ
        $response = Http::get("https://brasilapi.com.br/api/cnpj/v1/{$cnpj}");

        if ($response->successful()) {
            Cache::put("cnpj_{$cnpj}", $response->json(), 60 * 60);
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'CNPJ não encontrado ou serviço indisponível.'], $response->status());
        }
    }
}
