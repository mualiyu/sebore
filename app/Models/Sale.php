<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_id',
        'marketer_id',
        'store_id',
        'store_keeper_id',
        'item_id',
        'from',
        'to',
        'expiration',
        'amount',
        'quantity',
        'ref_num',
        'status',
    ];

    public function org(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'org_id');
    }

    public function marketer(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'marketer_id');
    }

    public function store_keeper(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'store_keeper_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
