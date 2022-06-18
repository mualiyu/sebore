<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'org_id',
        'total_num_of_items',
        'total_amount',
    ];

    public function org(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'org_id');
    }

    //hasmany agents
    public function agents(): BelongsToMany
    {
        return $this->belongsToMany(Agent::class);
    }

    public function items_in_store(): HasMany
    {
        return $this->hasMany(ItemInStore::class);
    }
}
