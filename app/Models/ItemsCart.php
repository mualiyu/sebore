<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemsCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'measure',
        'unit',
        'code',
        'with_q',
        'with_p',
        'device_id',
        'category_id',
        'image',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
