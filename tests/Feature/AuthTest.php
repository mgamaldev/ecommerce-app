<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\ApiBaseTest;

class AuthTest extends ApiBaseTest
{
    use RefreshDatabase;

    public function test_user_register(): void
    {
        $response = $this->postJson('api/register', [
            'name' => 'nadine',
            'email' => 'nadine@gmail.com',
            'password' => 'Password@123',
            'password_confirmation' => 'Password@123',
        ]);

        $this->assertApiSuccess($response);

        $this->assertDatabaseHas('users', [
            'email' => 'nadine@gmail.com',
        ]);
    }

    public function test_register_validation_error(): void
    {
        $response = $this->postJson('api/register', []);

        $this->assertValidationError($response, ['email', 'password']);
    }

    public function test_user_login(): void
    {
        $user = \App\Models\User::factory()->create([
            'password' => bcrypt('Password@123'),
        ]);

        $response = $this->postJson('api/login', [
            'email' => $user->email,
            'password' => 'Password@123',
        ]);

        $this->assertApiSuccess($response);
    }

    public function test_login_validation_error(): void
    {
        $response = $this->postJson('api/login', []);

        $this->assertValidationError($response, ['email', 'password']);
    }
}
