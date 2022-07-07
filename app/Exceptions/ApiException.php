<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class ApiException extends Exception
{
    public function __construct(
        protected string $msg = ""
    )
    {
        parent::__construct();
    }

    public function render(): JsonResponse
    {
        return (new ApiResponse(
            message: $this->msg
        ))->asBadRequest();
    }
}
