<?php

namespace App\Traits;

trait ApiResponses
{
    protected function ok($message, $data = []): \Illuminate\Http\JsonResponse
    {
        return $this->success($message, $data, 200);
    }

    protected function success($message, $data = [], $statusCode = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'status' => $statusCode,
        ], $statusCode);
    }

    protected function error($errors = [], $statusCode = null): \Illuminate\Http\JsonResponse
    {
        if (is_string($errors)) {
            return response()->json([
                'message' => $errors,
                'status' => $statusCode
            ], $statusCode);
        }
        return response()->json([
            'errors' => $errors
        ]);
    }

    protected function notAuthorized($message): \Illuminate\Http\JsonResponse
    {
        return $this->error([
            'status' => 401,
            'message' => $message,
            'source' => ''
        ]);
    }
}
