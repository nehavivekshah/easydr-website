<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicines extends Model
{
    use HasFactory;
    
    public function cart_items() {
        return $this->hasMany(Carts::class, 'medicine_id');
    }
}
