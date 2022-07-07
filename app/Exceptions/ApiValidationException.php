<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class ApiValidationException extends Exception
{
    public function __construct(
        protected array $errors,
        protected string $msg = "A validation error has occurred."
    )
    {
        parent::__construct();
    }

    public function render(): JsonResponse
    {
        return (new ApiResponse(
            data: [],
            message: __('validation.failed'),
            error: $this->errors
        ))->asValidationError();
    }
}
