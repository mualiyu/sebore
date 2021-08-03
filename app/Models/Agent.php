<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'phone',
        'address',
        'lga',
        'state',
        'country',
        'gps',
        'role',
        'user'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //hasmany agents
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }
}
