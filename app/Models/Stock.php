<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_id',
        'issuer',
        'collector',
        'amount',
        'status',
    ];

    public function org(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'org_id');
    }

    public function collector(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'collector');
    }

    public function issuer(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'issuer');
    }
}
