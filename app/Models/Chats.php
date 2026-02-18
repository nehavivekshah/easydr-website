<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    use HasFactory;

    protected $fillable = ['pid', 'did', 'sender_id', 'aid', 'msg', 'file', 'status'];
}
