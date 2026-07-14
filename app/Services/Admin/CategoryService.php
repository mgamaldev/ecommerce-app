<?php

namespace App\Services\Admin;

use App\Models\Category;

class CategoryService extends BaseCrudService
{
    protected function getModelClass(): string
    {
        return Category::class;
    }
}
