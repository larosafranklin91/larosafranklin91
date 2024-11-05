<?php

namespace App\Http\Controllers;

use App\Actions\SearchCompanyByDocument;
use App\Exceptions\BadRequestException;
use App\Http\Integrations\BrasilApi\BrasilAPI;
use App\Http\Requests\SearchCompanyRequest;
use App\Support\Document\Cnpj;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchCompanyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SearchCompanyRequest $request, $document, SearchCompanyByDocument $action): JsonResponse
    {
        $company = $action->handle($document);

        return response()->json([
            'data' => $company,
        ]);
    }
}
