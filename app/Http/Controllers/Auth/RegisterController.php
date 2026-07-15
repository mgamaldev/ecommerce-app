<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\RegisterResource;
use App\Services\Auth\RegisterService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;

class RegisterController extends ApiController
{
    public function __construct(protected RegisterService $registerService) {}

    public function store(RegisterRequest $request): JsonResponse
    {
        $userRegister = $this->registerService->register($request);

        event(new Registered($userRegister));

        return $this->success(new RegisterResource($userRegister), 'User Registered Successfully');
    }
}
