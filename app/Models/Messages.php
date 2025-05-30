<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function senderMessage(){
        return $this->belongsTo(User::class,'sender_id');
    }
    public function recipientMessage(){
        return $this->belongsTo(User::class,'recipient_id');
    }
}
