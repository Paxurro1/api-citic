<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Afinidad extends Model
{
    use HasFactory;

    protected $table = 'afinidad';
    protected $primaryKey = ['email1', 'email2'];
    public $incrementing = false;
    protected $keyType = ['string', 'string'];
    protected $fillable = [
        'email1',
        'email2',
        'afinidad'
    ];
}
