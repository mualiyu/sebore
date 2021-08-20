<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdminRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'permission',
    ];


    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
