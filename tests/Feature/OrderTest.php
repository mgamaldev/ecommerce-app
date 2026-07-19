<?php

namespace Tests\Feature;

use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\ApiBaseTest;

class OrderTest extends ApiBaseTest
{
    use RefreshDatabase;

    public function test_order_checkout(): void
    {
        $user = \App\Models\User::factory()->create();

        $wallet = \App\Models\Wallet::factory()->create([
            'user_id' => $user->id,
            'balance' => 1000,
        ]);

        $product = \App\Models\Product::factory()->create();

        $variant = \App\Models\Variant::factory()->create([
            'product_id' => $product->id,

        ]);

        $cart = \App\Models\Cart::factory()->create();

        $cartItem = \App\Models\CartItem::factory()->create([
            'cart_id' => $cart->id]);

        $this->mock(PaymentGatewayInterface::class, function ($mock) {
            $mock->shouldReceive('checkout')
                ->once()
                ->andReturn([
                    'url' => 'https://checkout.test',
                    'session_id' => 'cs_test_123',
                ]);
        });
        $response = $this->actingAs($user, 'sanctum')
            ->postJson('api/checkout', [
                'variant_id' => $variant->id,
                'quantity' => 1,
            ]);

        $this->assertApiSuccess($response);
    }
}
