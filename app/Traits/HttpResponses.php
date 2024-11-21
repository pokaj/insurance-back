<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HttpResponses {

    protected function success($data, $message = null, $code = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error($code, $message = null): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], $code);
    }
}
