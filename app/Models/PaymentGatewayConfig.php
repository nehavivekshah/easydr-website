<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGatewayConfig extends Model
{
    use HasFactory;

    protected $table = 'payment_gateway_configs';

    protected $fillable = [
        'gateway_name',
        'merchant_id',
        'api_key',
        'api_secret',
        'webhook_secret',
        'environment',
        'is_active',
        'additional_config',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'additional_config' => 'array',
    ];
}
