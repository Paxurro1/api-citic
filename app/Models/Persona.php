<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $primaryKey = 'email';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'email',
        'nombre',
        'pass',
        'f_nac',
        'ciudad',
        'descripcion',
        'tipo_relacion',
        'tieneHijos',
        'quiereHijos',
        'foto',
        'conectado',
        'activo',
        'tema',
        'id_genero'
    ];

}
