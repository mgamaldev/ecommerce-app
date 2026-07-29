<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OutOfStockExceptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_returns_out_of_stock_exception(): void
    {

        $user = User::factory()->create();

        $unusedProduct = Product::factory()->create([
            'stock' => 100,
        ]);

        $product = Product::factory()->create([
            'stock' => 0,
            'base_price' => 100,
        ]);

        $variant = Variant::factory()->create([
            'product_id' => $product->id,
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/checkout', [
                'variant_id' => $variant->id,
                'quantity' => 2,
            ]);

        $response->assertStatus(400);

        $response->assertJson([
            'message' => 'product is out of stock',
            'errors' => null,
            'code' => 'OUT_OF_STOCK',
        ]);
    }
}
