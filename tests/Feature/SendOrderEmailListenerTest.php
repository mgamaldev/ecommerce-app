<?php

namespace Tests\Feature;

use App\Events\OrderPlaced;
use App\Interfaces\PaymentGatewayInterface;
use App\Listeners\SendOrderEmailListener;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\ApiBaseTest;

class SendOrderEmailListenerTest extends ApiBaseTest
{
    use RefreshDatabase;

    public function test_listener_handle_event()
    {
        $user = \App\Models\User::factory()->create();

        $wallet = \App\Models\Wallet::factory()->create();

        $product = \App\Models\Product::factory()->create();

        $variant = \App\Models\Variant::factory()->create();

        $order = \App\Models\Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'total_amount' => 100,
            'status' => 'pending',
        ]);
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
        $event = new OrderPlaced($order);

        (new SendOrderEmailListener)->handle($event);

        $this->assertApiSuccess($response);
    }
}
