<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Services\Auth\LoginService;
use Illuminate\Http\JsonResponse;

class LoginController extends ApiController
{
    public function __construct(protected LoginService $loginService) {}

    /**
     * Log in a user.
     *
     * Authenticate the user and return an access token.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $userLogin = $this->loginService->login($request);

        return $this->success([
            'user' => new LoginResource($userLogin['user']),
            'token' => $userLogin['token'],
        ], 'User Logged in Successfully');
    }
}
