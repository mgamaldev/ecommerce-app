<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =
        [
            'category_id',
            'name',
            'slug',
            'stock',
            'description',
            'base_price',
        ];

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imagable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function auditLogs(): MorphMany
    {
        return $this->morphMany(AuditLogs::class, 'auditable');
    }

    public function scopeFilter($query, $request = null)
    {
        $query->when($request?->category, function ($q) use ($request) {
            $q->whereHas('category', function ($categoryQuery) use ($request) {
                $categoryQuery->where('name', 'like', '%'.$request->category.'%');
            });
        });
    }
}
