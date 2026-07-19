<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\AdminByPass;

class UserPolicy
{
    use AdminByPass;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, User $targetUser): bool
    {
        return $user->id === $targetUser->id || $user->isAdmin();
    }

    public function update(User $user): bool
    {
        return $user->isAdmin();
    }
}
