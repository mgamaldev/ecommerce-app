<?php

namespace Tests\Feature;

use App\Events\OrderPlaced;
use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\Support\ApiBaseTest;

class OrderEventTest extends ApiBaseTest
{
    use RefreshDatabase;

    public function test_checkout_dispatch_order_event(): void
    {
        Event::fake();

        $user = \App\Models\User::factory()->create();

        $wallet = \App\Models\Wallet::factory()->create();

        $product = \App\Models\Product::factory()->create();

        $variant = \App\Models\Variant::factory()->create();

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

        Event::assertDispatched(OrderPlaced::class);

        $this->assertApiSuccess($response);
    }
}
