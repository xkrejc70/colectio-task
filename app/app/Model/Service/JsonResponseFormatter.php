<?php

namespace App\Model\Service;

class JsonResponseFormatter {

    public static function success($data): array
    {
        return [
            'status' => 'success',
            'data' => $data
        ];
    }

    public static function error(string $message, int $statusCode): array
    {
        return [
            'status' => 'error',
            'message' => $message,
            'code' => $statusCode
        ];
    }
}
