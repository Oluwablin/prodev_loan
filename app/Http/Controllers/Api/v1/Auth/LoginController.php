<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AuthService;
use App\Helpers\ApiResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function Login (LoginRequest $request){


        extract($request->all());

        $data = $this->authService->login($email, $password);

        return (new ApiResponse(
            data: $data,
            message: __('auth.successful')
        ))->asSuccessful();

    }

    public function logout(Request $request)
    {
        $this->authService->logout();

        return (new ApiResponse(
            message: __('auth.logout')
        ))->asSuccessful();

    }
}
