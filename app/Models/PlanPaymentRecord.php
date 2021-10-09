<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPaymentRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_id',
        'plan_id',
        'amount',
        'status',
        'ref_num',
        'transaction_date',
        'customer_code',
    ];
}
