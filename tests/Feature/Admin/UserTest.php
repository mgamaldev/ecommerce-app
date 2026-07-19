<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\Traits\AdminCrudAssertions;
use Tests\Support\Traits\ReadUpdateCrudTestSuite;
use Tests\TestCase;

class UserTest extends TestCase
{
    use AdminCrudAssertions;
    use ReadUpdateCrudTestSuite;
    use RefreshDatabase;

    protected function endpoint(): string
    {
        return '/api/admin/users';
    }

    protected function modelFactory()
    {
        return User::class;
    }

    protected function updateValidData(): array
    {
        return [
            'active_status' => true,
        ];
    }
}
