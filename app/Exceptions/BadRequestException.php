<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class BadRequestException extends Exception
{
    public function render():JsonResponse
    {
        return response()->json([
            'message' => $this->message,
        ], 400);
    }
}
