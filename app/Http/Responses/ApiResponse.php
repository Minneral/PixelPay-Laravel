<?php

namespace App\Http\Responses;

class ApiResponse
{
    public static function send($data = null, $message = null, $status = 200, $error = false)
    {
        return response()->json([
            'status' => $status === 200 && !$error ? 'OK' : 'ERROR',
            'message' => $message,
            'data' => $data
        ], $status);
    }
}
