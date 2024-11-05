<?php

namespace App\Exceptions;

use Exception;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class NotFoundException extends Exception
{
    protected $message = 'Resource not found';

    public function render(): JsonResponse
    {
        return response()->json([
            'message' => $this->message
        ], Response::HTTP_NOT_FOUND);
    }
}
