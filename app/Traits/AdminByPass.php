<?php

namespace App\Traits;

use App\Models\User;

trait AdminByPass
{
    public function before(User $user)
    {
        return $user->isAdmin() ? true : null;
    }
}
