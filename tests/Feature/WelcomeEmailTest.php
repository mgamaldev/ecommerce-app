<?php

namespace Tests\Feature;

use App\Mail\WelcomeEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\Support\ApiBaseTest;

class WelcomeEmailTest extends ApiBaseTest
{
    use RefreshDatabase;

    public function test_welcome_email_after_registration()
    {
        Mail::fake();

        $response = $this->postJson('api/register', [
            'name' => 'nadine',
            'email' => 'nadine@gmail.com',
            'password' => 'Password@123',
            'password_confirmation' => 'Password@123',
        ]);

        $response->assertOk();

        Mail::assertQueued(WelcomeEmail::class);
    }
}
