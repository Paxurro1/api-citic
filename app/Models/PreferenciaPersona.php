<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferenciaPersona extends Model
{
    use HasFactory;

    protected $table = 'preferencia_personas';
    protected $primaryKey = ['email', 'id_preferencia'];
    public $incrementing = false;
    protected $keyType = ['string', 'unsignedBigInteger'];
    protected $fillable = [
        'email',
        'id_preferencia',
        'intensidad'
    ];
}
