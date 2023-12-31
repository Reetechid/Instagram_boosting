<?php

namespace App\Services;

class SuccessResponseService
{
    public function sendSuccessResponse($data, $statusCode = 200)
    {
        return response()->json([
            'status' => $statusCode,
            'message' => 'success',
            'data' => $data,
        ], $statusCode);
    }
}
