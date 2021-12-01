<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $primaryKey = ['email_origen', 'email_destino'];
    public $incrementing = false;
    protected $keyType = ['string', 'string'];
    protected $fillable = [
        'email_origen',
        'email_destino'
    ];
}
