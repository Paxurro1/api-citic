<?php

namespace App\Http\Controllers;

use App\Models\GustoGenero;
use App\Models\Persona;
use App\Models\PreferenciaPersona;
use App\Models\RolAsig;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class controladorAdministradores extends Controller
{
    public function getUsuarios()
    {
        $usuarios = Persona::all();
        if ($usuarios) {
            foreach ($usuarios as $u) {
                $roles = RolAsig::where('email', '=', $u->email)
                    ->select('id_rol')
                    ->get();
                $u->roles = $roles;
            }
            return response()->json($usuarios, 200);
        } else {
            return response()->json(['mensaje' => 'Error al obtener los usuarios.'], 402);
        }
    }

    public function addUsuario(Request $request)
    {
        $roles = $request->get('roles');
        // error_log(print_r($request->get('email'), true));
        $usuario_email = DB::table('personas')->where('email', $request->get('email'))->first();
        // error_log(print_r($usuario, true));
        if (!$usuario_email) {
            // error_log(print_r('entra', true));
            Persona::create([
                'email' => $request->get('email'),
                'nombre' => $request->get('nombre'),
                'pass' => Hash::make($request->get('pass')),
                'f_nac' => $request->get('date'),
                'ciudad' => '',
                'descripcion' => '',
                'tipo_relacion' => '',
                'tieneHijos' => 0,
                'quiereHijos' => 0,
                'foto' => '/images/prueba/'.rand(1,32).'.jpg',
                'conectado' => 0,
                'activo' => $request->get('activo'),
                'tema' => 0,
                'id_genero' => $request->get('sexo'),
            ]);
            PreferenciaPersona::create([
                'email' => $request->get('email'),
                'id_preferencia' => 1,
                'intensidad' => 0
            ]);
            PreferenciaPersona::create([
                'email' => $request->get('email'),
                'id_preferencia' => 2,
                'intensidad' => 0
            ]);
            PreferenciaPersona::create([
                'email' => $request->get('email'),
                'id_preferencia' => 3,
                'intensidad' => 0
            ]);
            PreferenciaPersona::create([
                'email' => $request->get('email'),
                'id_preferencia' => 4,
                'intensidad' => 0
            ]);
            PreferenciaPersona::create([
                'email' => $request->get('email'),
                'id_preferencia' => 5,
                'intensidad' => 0
            ]);
            GustoGenero::create([
                'email' => $request->get('email'),
                'id_genero' => 1
            ]);
            GustoGenero::create([
                'email' => $request->get('email'),
                'id_genero' => 2
            ]);
            foreach ($roles as $r) {
                // error_log($r);
                RolAsig::create(['id_rol' => $r, 'email' => $request->get('email')]);
            }
            return response()->json(['mensaje' => 'Se ha registrado el usuario'], 200);
        } else {
            return response()->json(['mensaje' => 'No se pudo registrar el usuario'], 400);
        }
    }

    public function editarUsuario(Request $request)
    {
        try {
            $email = $request->get('email');
            // error_log($email);
            $nombre = $request->get('nombre');
            // error_log($nombre);
            $activo = $request->get('activo');
            // error_log(print_r($activo[0], true));
            $roles = $request->get('roles');
            // error_log(print_r($roles, true));
            $emailAntiguo = $request->get('emailAntiguo');
            // error_log($emailAntiguo);
            Persona::where('email', $emailAntiguo)
                ->update(['email' => $email, 'nombre' => $nombre, 'activo' => $activo[0]]);
            RolAsig::where('email', '=', $emailAntiguo)->delete();
            RolAsig::where('email', '=', $email)->delete();
            foreach ($roles as $r) {
                // error_log($r);
                RolAsig::create(['id_rol' => $r, 'email' => $email]);
            }
            return response()->json(['mensaje' => 'Usuario actualizado'], 200);
        } catch (Exception $th) {
            return response()->json(['mensaje' => $th->getMessage()], 400);
        }
    }

    public function borrarUsuario(string $email)
    {
        // error_log($dni);
        $usuario = Persona::where('email', '=', $email)->get();
        if ($usuario) {
            Persona::where('email', '=', $email)->delete();
            return response()->json(['mensaje' => 'Se ha eliminado el usuario'], 200);
        } else {
            return response()->json(['mensaje' => 'No se pudo eliminar el usuario'], 400);
        }
        // error_log(print_r($usuario, true));
    }
}
