<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;
    public function family_doctor()
    {
        return $this->belongsTo(User::class, 'family_doctor_id', 'id');
    }
}
