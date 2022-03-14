<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'lga',
        'state',
        'country',
        'gps',
        'agent',
    ];


    public function agents(): BelongsToMany  //BelongsTo
    {
        // return $this->belongsTo(Agent::class);
        return $this->belongsToMany(Agent::class);
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
