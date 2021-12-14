<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;
    protected $fillable = [
        'email_origen',
        'email_destino',
        'texto',
        'leido'
    ];
    public function adjunto(){
        return $this->hasMany(Adjunto::class, 'id','id');
    }
}
