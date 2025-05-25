<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function users(){
        return $this->belongsToMany(User::class , 'departments_users');
    }
    public function documents(){
        return $this->belongsToMany(Document::class , 'departments_documents');
    }
}
