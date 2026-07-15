<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    public function getAllProducts($request = null): Collection
    {
        return Product::Filter($request)->where('stock', '>', 0)->get();
    }

    public function getProductDetails(int $id): Product
    {
        return Product::with('variants')->findOrFail($id);
    }
}
