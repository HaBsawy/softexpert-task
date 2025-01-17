<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Http\Requests\API\LoginRequest;
use Illuminate\Http\JsonResponse;

class AuthService
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return ResponseHelper::unauthenticated();
        }

        return ResponseHelper::make($this->AccessTokenResponse($token), 202,
            true, 'login successfully');
    }

    public function me(): JsonResponse
    {
        return ResponseHelper::make(auth()->user());
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        return ResponseHelper::make(null, 202,
            true, 'logout successfully');
    }

    public function refresh(): JsonResponse
    {
        return ResponseHelper::make($this->AccessTokenResponse(auth()->refresh()), 202);
    }

    private function AccessTokenResponse($token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
