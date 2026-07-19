<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\Traits\AdminCrudAssertions;
use Tests\Support\Traits\AdminCrudTestSuite;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use AdminCrudAssertions;
    use AdminCrudTestSuite;
    use RefreshDatabase;

    protected function endpoint(): string
    {
        return '/api/admin/products';
    }

    protected function modelFactory()
    {
        return Product::class;
    }

    protected function storeValidData(): array
    {
        $category = Category::factory()->create();

        return [
            'name' => 'nada',
            'category_id' => $category->id,
            'slug' => 'unique-slug-'.time(),
            'description' => 'Latest iPhone',
            'stock' => 10,
            'base_price' => 1000,
        ];
    }

    protected function updateValidData(): array
    {
        return [
            'name' => 'pencil',
        ];
    }
}
