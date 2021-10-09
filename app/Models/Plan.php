<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'no_devices',
        'no_agents',
        'no_customers',
        'no_transactions',
    ];

    /**
     * Undocumented function
     *
     * @return BelongsTo
     */
    public function plan_details(): HasMany
    {
        return $this->hasMany(PlanDetail::class);
    }
}
