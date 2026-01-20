<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type', // e.g., 'order', 'appointment', 'system'
        'is_read',
        'data' // JSON for extra details
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean'
    ];
}
