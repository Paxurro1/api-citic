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
    public function amigos(){
        return $this->hasMany(Amigo::class, 'email1' ,'email');
    }
    public function dislikeRecibido(){
        return $this->hasMany(Dislike::class, 'email_destino','email');
    }
    public function dislikeDado(){
        return $this->hasMany(Dislike::class, 'email_origen','email');
    }
    public function rolasig(){
        return $this->hasMany(RolAsig::class, 'email','email');
    }
    public function mensajes(){
        return $this->hasMany(Mensaje::class, 'email_origen','email');
    }
    public function preferencias(){
        return $this->hasMany(PreferenciaPersona::class, 'email','email');
    }
    public function likeRecibido(){
        return $this->hasMany(Like::class, 'email_destino','email');
    }
    public function likeDado(){
        return $this->hasMany(Like::class, 'email_origen','email');
    }
    public function gusto(){
        return $this->hasMany(GustoGenero::class, 'email','email');
    }
    public function afinidad(){
        return $this->hasMany(Afinidad::class, 'email1','email');
    }
}
