<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Admin\UserService;
use Illuminate\Http\JsonResponse;

class AdminUserController extends ApiController
{
    public function __construct(protected UserService $userService) {}

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', User::class);

        $users = $this->userService->getAllUsers();

        return $this->success(UserResource::collection($users), 'All users');
    }

    public function show(User $user): JsonResponse
    {
        $this->authorize('view', $user);

        $user = $this->userService->getUserDetails($user->id);

        return $this->success(new UserResource($user), 'User Details');
    }

    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        $this->authorize('update', $user);

        $user = $this->userService->deactivateUser($user->id);

        return $this->success(new UserResource($user), 'User Deactivate Successfully');
    }
}
