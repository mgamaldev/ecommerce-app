<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function getAllCategories($request = null): Collection
    {
        return Category::Filter($request)->get();
    }

    public function getCategoryDetails(int $id): Category
    {
        return Category::with('products')->findOrFail($id);
    }
}
