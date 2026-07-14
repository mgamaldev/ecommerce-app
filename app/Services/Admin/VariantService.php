<?php

namespace App\Services\Admin;

use App\Models\Variant;

class VariantService extends BaseCrudService
{
    protected function getModelClass(): string
    {
        return Variant::class;
    }
}
