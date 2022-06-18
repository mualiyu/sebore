<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'from_id',
        'to_id',
        'status',
        'type',
        'ref_num',
        'gateway_code'
    ];
}
