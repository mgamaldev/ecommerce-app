<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =
        [
            'product_id',
            'sku',
            'price',
            'variant_stock',
            'color',
            'size',
        ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function auditLogs(): MorphMany
    {
        return $this->morphMany(AuditLogs::class, 'auditable');
    }

    public function scopeFilter($query, $request = null)
    {
        $query->when($request?->product, function ($q) use ($request) {
            $q->whereHas('product', function ($productQuery) use ($request) {
                $productQuery->where('name', 'like', '%'.$request->product.'%');
            });
        });

        $query->when($request?->color, function ($q) use ($request) {
            $q->where('color', $request->color);
        });

        $query->when($request?->size, function ($q) use ($request) {
            $q->where('size', '=', $request->size);
        });

        $query->when($request?->price, function ($q) use ($request) {
            $q->where('price', '=', $request->price);
        });
    }
}
