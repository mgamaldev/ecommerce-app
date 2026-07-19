<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\ApiBaseTest;

class CartTest extends ApiBaseTest
{
    use RefreshDatabase;

    public function test_get_user_cart(): void
    {
        $user = \App\Models\User::factory()->create();

        $cart = \App\Models\Cart::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->getJson('api/cart');

        $this->assertApiSuccess($response);
    }
}
