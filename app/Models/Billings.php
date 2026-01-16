<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billings extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'order_id',
        'total_amount',
        'payment_status',
    ];
}
