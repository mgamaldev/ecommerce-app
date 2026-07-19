<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =
        [

            'name',
            'slug',
            'description',

        ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function auditLogs(): MorphMany
    {
        return $this->morphMany(AuditLogs::class, 'auditable');
    }

    public function scopeFilter($query, $request = null)
    {
        $query->when($request?->name, function ($q) use ($request) {
            $q->where('name', 'like', '%'.$request->name.'%');
        });
    }
}
