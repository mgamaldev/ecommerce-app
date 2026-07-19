<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\Traits\AdminCrudAssertions;
use Tests\Support\Traits\AdminCrudTestSuite;
use Tests\TestCase;

class VariantTest extends TestCase
{
    use AdminCrudAssertions;
    use AdminCrudTestSuite;
    use RefreshDatabase;

    protected function endpoint(): string
    {
        return '/api/admin/variants';
    }

    protected function modelFactory()
    {
        return Variant::class;
    }

    protected function storeValidData(): array
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
        ]);

        return [
            'product_id' => $product->id,
            'sku' => 'SKU-4908',
            'price' => 10,
            'variant_stock' => 3,
            'color' => 'white',
            'size' => 50,
        ];
    }

    protected function updateValidData(): array
    {
        return [
            'color' => 'black',
        ];
    }
}
