<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'location',
        'device_id',
        'user',
        'org_id',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Undocumented function
     *
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'org_id');
    }

    public function org(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
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
