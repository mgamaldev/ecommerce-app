<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\Traits\AdminCrudAssertions;
use Tests\Support\Traits\AdminCrudTestSuite;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use AdminCrudAssertions;
    use AdminCrudTestSuite;
    use RefreshDatabase;

    protected function endpoint(): string
    {
        return '/api/admin/categories';
    }

    protected function modelFactory()
    {
        return Category::class;
    }

    protected function storeValidData(): array
    {
        return [
            'name' => 'elect',
            'slug' => 'unique-slug-'.time(),
            'description' => 'elect',
        ];
    }

    protected function updateValidData(): array
    {
        return [
            'name' => 'kitchen',
        ];
    }
}
