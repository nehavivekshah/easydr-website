<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    use HasFactory;

    // Explicit table name (important if pluralization mismatches)
    protected $table = 'carts';

    // Mass assignable fields
    protected $fillable = [
        'user_id',
        'medicine_id',
        'quantity'
    ];

    // Default values
    protected $attributes = [
        'quantity' => 0,
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicines::class, 'medicine_id');
    }
}
