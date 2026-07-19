<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;

class LoginService
{
    /**
     * Create a new class instance.
     */
    public function login(LoginRequest $request): array
    {
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('loginToken')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }
}
