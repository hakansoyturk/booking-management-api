<?php

namespace App\Helpers;

use Illuminate\Http\Response;

class ResponseHelper
{
    public static function handleException($message, $data, $status)
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public static function createResponse($message, $data, $status)
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $status);
    }
}