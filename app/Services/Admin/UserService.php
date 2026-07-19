<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    public function getAllUsers($request = null, int $perPage = 10): LengthAwarePaginator
    {
        return $users = User::Filter($request)->paginate($perPage);
    }

    public function getUserDetails(int $id): User
    {
        return $user = User::findOrFail($id);
    }

    public function deactivateUser(int $id): User
    {
        $user = User::findOrFail($id);
        $user->update([
            'active_status' => false,
        ]);

        return $user;
    }
}
