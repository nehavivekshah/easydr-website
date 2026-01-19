<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallets extends Model
{
    use HasFactory;

    protected $table = 'wallets';

    protected $fillable = [
        'did',         // Doctor ID
        'aid',         // Booking/Appointment ID
        'details',     // Transaction description
        'amount',      // Transaction amount
        'status',      // Status: credit / pending / health_card
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'did', 'id');
    }
}
