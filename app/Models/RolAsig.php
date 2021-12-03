<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolAsig extends Model
{
    use HasFactory;

    protected $table = 'roles_asignados';
    protected $primaryKey = ['email', 'id_rol'];
    public $incrementing = false;
    protected $keyType = ['string', 'unsignedBigInteger'];
    protected $fillable = [
        'email',
        'id_rol'
    ];
}
