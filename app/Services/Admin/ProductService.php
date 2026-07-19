<?php

namespace App\Services\Admin;

use App\Models\Product;

class ProductService extends BaseCrudService
{
    protected function getModelClass(): string
    {
        return Product::class;
    }
}
