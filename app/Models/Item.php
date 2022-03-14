<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_id',
        'device_id',
        'item_cart_id'
    ];


    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function item_cart(): BelongsTo
    {
        return $this->belongsTo(ItemsCart::class, 'item_cart_id');
    }

    /**
     * Undocumented function
     *
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Undocumented function
     *
     * @return HasMany
     */
    public function sale_transactions(): HasMany
    {
        return $this->hasMany(SaleTransaction::class);
    }
}
