<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class ApiResponse
{
    const OK = 200;
    const CREATED = 201;
    const UPDATED = 202;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const NOT_FOUND = 404;
    const VALIDATION_ERROR = 422;
    const SERVER_ERROR = 500;


    public function __construct(
        protected array $data = [],
        protected string $message = '',
        protected string|array $error = []
    )
    {}

    public function asSuccessful() : JsonResponse
    {
        return $this->responseArray(self::OK);
    }

    public function asBadRequest() : JsonResponse
    {
        return $this->responseArray(self::BAD_REQUEST);
    }

    public function asCreated() : JsonResponse
    {
        return $this->responseArray(self::CREATED);
    }

    public function asUpdated() : JsonResponse
    {
        return $this->responseArray(self::UPDATED);
    }

    public function asNotFound() : JsonResponse
    {
        return $this->responseArray(self::NOT_FOUND);
    }

    public function asServerError() : JsonResponse
    {
        return $this->responseArray(self::SERVER_ERROR);
    }

    public function asValidationError() : JsonResponse
    {
        return $this->responseArray(self::VALIDATION_ERROR);
    }

    public function asUnauthorizedError() : JsonResponse
    {
        return $this->responseArray(self::UNAUTHORIZED);
    }

    private function responseArray(int $statusCode) : JsonResponse
    {
        return response()->json([
            'success' => $statusCode <= 202,
            'data' => $this->data,
            'message' => $this->message,
            'error' => $this->error,
        ], $statusCode);
    }
}
