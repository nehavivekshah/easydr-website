<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_id',
        'supplier_id',
        'shipping_address',
        'order_date',
        'status',
        'total_amount',
        'payment_method',
        'payment_gateway_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function store()
    {
        return $this->belongsTo(Store_locations::class, 'store_id', 'LocationID');
    }

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(OrderItems::class, 'order_id');
    }
}
