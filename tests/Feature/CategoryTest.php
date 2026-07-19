<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\ApiBaseTest;

class CategoryTest extends ApiBaseTest
{
    use RefreshDatabase;

    public function test_get_categories_list(): void
    {
        $category = \App\Models\Category::factory()->create();

        $response = $this->getJson('/api/category');

        $this->assertApiSuccess($response);
    }

    public function test_get_category_details(): void
    {

        $category = \App\Models\Category::factory()->create();

        $response = $this->getJson('/api/category/'.$category->id);

        $this->assertApiSuccess($response);
    }
}
