<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory , SoftDeletes;
    protected $guarded = [];

    public function departments(){
        return $this->belongsToMany(Department::class, 'departments_documents', 'document_id', 'department_id');
    }    
    public function owners(){
        return $this->belongsTo(User::class , 'owner');
    }
    public function signature(){
        return $this->hasMany(Signature::class , 'document_id')->orderBy('created_at', 'desc');
    }
    public function logs()
{
    return $this->hasMany(DocumentLog::class);
}

}
