<?php

namespace App\Http\Controllers;

use App\Models\GustoGenero;
use App\Models\Persona;
use App\Models\Preferencia;
use App\Models\PreferenciaPersona;
use App\Models\RolAsig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class controladorUsuario extends Controller
{
    public function loging(Request $req)
    {
        $email = $req->get('email');
        $pass = $req->get('pass');
        $per = Persona::where([
            ['email', $email],
        ])->get();

        $ckPass = Hash::check($pass, Persona::where('email', $email)->get()[0]->pass);

        if (count($per) > 0 && $ckPass) {
            return response()->json($per, 200);
        } else {
            return response()->json(['mensaje' => 'error'], 403);
        }
    }

    public function registro(Request $req)
    {
        $email = $req->get('email');
        $nombre = $req->get('nombre');
        $pass = $req->get('pass');
        $f_nac = $req->get('f_nac');
        $ciudad = $req->get('ciudad');
        $descripcion = $req->get('descripcion');
        $tipo_relacion = $req->get('tipo_relacion');
        $tieneHijos = $req->get('tieneHijos');
        $quiereHijos = $req->get('quiereHijos');
        $foto = $req->get('foto');
        if (!Persona::find($email)) {
            $per = new Persona;
            $per->email = $email;
            $per->nombre = $nombre;
            $per->pass = Hash::make($pass);
            $per->f_nac = $f_nac;
            $per->ciudad = $ciudad;
            $per->descripcion = $descripcion;
            $per->tipo_relacion = $tipo_relacion;
            $per->tieneHijos = $tieneHijos;
            $per->quiereHijos = $quiereHijos;
            $per->foto = $foto;
            $per->conectado = '0';
            $per->activo = '0';
            $per->tema = '0';
            $per->id_genero = rand(1, 2);
            $per->save();
            for ($i = 1; $i <= Preferencia::all()->count(); $i++) {
                $pref = new PreferenciaPersona();
                $pref->email = $email;
                $pref->id_preferencia = $i;
                $pref->intensidad = $req->get('preferencia' . $i);
                $pref->save();
            }
            $rol = new RolAsig();
            $rol->email = $email;
            $rol->id_rol = '1';
            $rol->save();
            return response()->json(['mensaje' => 'Insertado con exito'], 200);
        } else {
            return response()->json(['mensaje' => 'error'], 404);
        }
    }

    public function listaPref(Request $req)
    {
        $email = $req->get('email');
        $per = Persona::where([
            ['email', $email],
        ])->get();
        $gustos = GustoGenero::where([

        ]);
    }
}
