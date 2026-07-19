<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLogs extends Model
{
    protected $fillable = [
        'actor_id',
        'action',
        'auditable_type',
        'auditable_id',
        'payload_before',
        'payload_after',
    ];

    public $casts = [
        'payload_before' => 'array',
        'payload_after' => 'array',
    ];

    public function auditable()
    {
        return $this->morphTo();
    }
}
