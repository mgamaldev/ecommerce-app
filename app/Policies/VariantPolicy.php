<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Variant;
use App\Traits\AdminByPass;

class VariantPolicy
{
    use AdminByPass;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Variant $variant): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Variant $variant): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Variant $variant): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Variant $variant): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Variant $variant): bool
    {
        return $user->isAdmin();
    }
}
