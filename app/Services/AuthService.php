<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\BaseService;
use App\Exceptions\ApiNotFoundException;
use App\Exceptions\ApiException;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService extends BaseService
{
    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Login a User
     */
    public function login(string $email, string $password): array
    {
        $user = $this->findUserByEmail($email);

        if (!$user) {
            throw new ApiException(__('settings.model_not_exist', ['model' => 'User']));
        }

        if (!$user->email_verified_at) {
            throw new ApiException(__('auth.unverified'));
        }

        if (!$attempt = Auth::attempt(['email' => $email, 'password' => $password])) {
            throw new ApiException(__('auth.failed'));
        }

        $data = [
            'accessToken' => $attempt,
            'tokenType' => 'Bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => $user,
        ];

        return $data;
    }

    private function findUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $logout = Auth::logout();

        return $logout;
    }
}