<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgentRole extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'name',
        'permission',
    ];


    public function agents(): HasMany
    {
        return $this->hasMany(Agent::class);
    }
}
