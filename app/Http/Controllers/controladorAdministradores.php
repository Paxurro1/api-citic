<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

class controladorAdministradores extends Controller
{
    public function listadoUsuarios() {
        $lista = Persona::all();
        return response()->json($lista, 200);
    }
}
