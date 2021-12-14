<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class controladorUsuario extends Controller
{
    public function loging(Request $req) {
        $email = $req->get('email');
        $pass = $req->get('pass');
        $per = Persona::where([
            ['email', $email],
        ])->get();

        $ckPass = Hash::check($pass, Persona::where('email', $email)->get()[0]->pass);

        if (count($per) > 0 && $ckPass) {
            return response()->json($per, 200);
        }else{
            return response()->json(['mensaje' => 'error'], 403);
        }
    }
}
