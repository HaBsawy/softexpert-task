<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    public static function make($data, $code = 200, $success = true, $message = ''): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status' => $code,
            'success' => $success,
            'data' => $data
        ], $code);
    }

    public static function unauthenticated(): JsonResponse
    {
        return self::make(null, 401, false, 'unauthenticated');
    }

    public static function notFound(): JsonResponse
    {
        return self::make(null, 404, false, 'not found');
    }

    public static function validationError($message): JsonResponse
    {
        return self::make(null, 422, false, $message);
    }

    public static function methodNotAllowed($message): JsonResponse
    {
        return self::make(null, 405, false, $message);
    }

    public static function accessDenied(): JsonResponse
    {
        return self::make(null, 403, false, 'not authorized');
    }

    public static function wentWrong($message): JsonResponse
    {
        return self::make(null, 500, false, $message);
    }
}
