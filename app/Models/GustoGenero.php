<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GustoGenero extends Model
{
    use HasFactory;

    protected $table = 'gusto_generos';
    protected $primaryKey = ['email', 'id_genero'];
    public $incrementing = false;
    protected $keyType = ['string', 'unsignedBigInteger'];
    protected $fillable = [
        'email',
        'id_genero'
    ];
}
