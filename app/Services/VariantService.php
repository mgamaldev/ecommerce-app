<?php

namespace App\Services;

use App\Models\Variant;
use Illuminate\Database\Eloquent\Collection;

class VariantService
{
    public function getAllVariant($request = null): Collection
    {
        return Variant::Filter($request)->where('variant_stock', '>', 0)->get();
    }
}
