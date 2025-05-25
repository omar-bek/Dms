<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentLog extends Model
{
    use HasFactory;
    protected $fillable = ['document_id', 'user_id', 'action', 'created_at'];

    public $timestamps = true;

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
