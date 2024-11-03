<?php

namespace App\Helpers;

use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class ExceptionHandler
{
    public static function tryCatchWrapper(callable $callback): JsonResponse
    {
        try {
            return $callback();
        } catch (ModelNotFoundException $e) {
            return self::handleException($e, 'Resource not found', 404);
        } catch (ValidationException $e) {
            return self::handleValidationException($e);
        } catch (HttpException $e) {
            return self::handleHttpException($e);
        } catch (QueryException $e) {
            return self::handleException($e, 'A query error occurred, please try again later', 500);
        } catch (Throwable $e) {
            return self::handleGenericException($e);
        }
    }

    protected static function handleException(Throwable $e, string $message, int $statusCode): JsonResponse
    {
        Log::critical($e);
        return response()->json(['message' => $message], $statusCode);
    }

    protected static function handleValidationException(ValidationException $e): JsonResponse
    {
        return response()->json(['message' => $e->errors()], 422);
    }

    protected static function handleHttpException(HttpException $e): JsonResponse
    {
        $statusCode = $e->getStatusCode();
        if (!self::isValidStatusCode($statusCode)) {
            $statusCode = 500;
        }
        return response()->json(['message' => 'An error occurred, please try again later'], $statusCode);
    }

    protected static function handleGenericException(Throwable $e): JsonResponse
    {
        $statusCode = $e->getCode();
        if (!self::isValidStatusCode($statusCode)) {
            $statusCode = 500;
        }
        if ($e instanceof \Exception) {
            return response()->json(['message' => $e->getMessage()], $statusCode);
        }

        Log::critical($e);
        return response()->json(['message' => 'An error occurred, please try again later'], $statusCode);
    }

    protected static function isValidStatusCode($statusCode): bool
    {
        return is_numeric($statusCode) && $statusCode >= 100 && $statusCode <= 599;
    }
}
