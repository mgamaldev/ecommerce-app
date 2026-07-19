<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\ApiBaseTest;

class ProductTest extends ApiBaseTest
{
    use RefreshDatabase;

    public function test_get_products_list(): void
    {
        $product = \App\Models\Product::factory()->create();

        $response = $this->getJson('/api/product');

        $this->assertApiSuccess($response);
    }

    public function test_get_product_details(): void
    {
        $product = \App\Models\Product::factory()->create();

        $response = $this->getJson('/api/product/'.$product->id);

        $this->assertApiSuccess($response);
    }
}
