<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Admin\UserService;
use Illuminate\Http\JsonResponse;

/**
 * @group Admin Users
 *
 * Endpoints for managing users. All endpoints in this group are available only to administrators.
 */
class AdminUserController extends ApiController
{
    public function __construct(protected UserService $userService) {}

    /**
     * List of all users.
     *
     * Retrieve all users.
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', User::class);

        $users = $this->userService->getAllUsers();

        return $this->success(UserResource::collection($users), 'All users');
    }

    /**
     * Show user details.
     *
     * Retrieve the details of a specific user.
     */
    public function show(User $user): JsonResponse
    {
        $this->authorize('view', $user);

        $user = $this->userService->getUserDetails($user->id);

        return $this->success(new UserResource($user), 'User Details');
    }

    /**
     * Deactivate a user.
     *
     * Mark a user account as inactive.
     */
    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        $this->authorize('update', $user);

        $user = $this->userService->deactivateUser($user->id);

        return $this->success(new UserResource($user), 'User Deactivate Successfully');
    }
}
