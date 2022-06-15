<?php

namespace App\Http\Controllers;

use App\Models\Afinidad;
use App\Models\Amigo;
use App\Models\Dislike;
use App\Models\GustoGenero;
use App\Models\Like;
use App\Models\Mensaje;
use App\Models\Persona;
use App\Models\Preferencia;
use App\Models\PreferenciaPersona;
use App\Models\RolAsig;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class controladorUsuario extends Controller
{
    public function login(Request $req)
    {
        $email = $req->get('email');
        $pass = $req->get('pass');
        $per = DB::table('personas')->where('email', $email)->first();
        $ckPass = Hash::check($pass, Persona::where('email', $email)->get()[0]->pass);

        if ($per && $ckPass) {
            if ($per->activo == 1) {
                Persona::where('email', $email)
                    ->update([
                        'conectado' => 1,
                    ]);
                $per = $this->getDatosUsuario($per);
                return response()->json($per, 200);
            } else {
                return response()->json(['mensaje' => 'Este usuario no está activo.'], 403);
            }
        } else {
            return response()->json(['mensaje' => 'Datos de inicio de sesión incorrectos.'], 403);
        }
    }

    public static function getDatosUsuario($usuario)
    {
        $usuario = Persona::where('email', '=', $usuario->email)
            ->select(['email', 'nombre'])
            ->first();
        $roles = RolAsig::where('email', '=', $usuario->email)
            ->select('id_rol')
            ->get();
        $usuario->roles = $roles;
        return $usuario;
    }

    public function registro(Request $req)
    {
        $email = $req->get('email');
        // error_log($email);
        $nombre = $req->get('nombre');
        // error_log($nombre);
        $pass = $req->get('pass');
        $ciudad = $req->get('ciudad');
        $desc = $req->get('desc');
        $date = $req->get('date');
        $tipo_relacion = $req->get('tipoRelacion');
        $tieneHijos = $req->get('tieneHijos');
        $quiereHijos = $req->get('quiereHijos');
        $id_genero = $req->get('sexo');
        $deporte = $req->get('deporte');
        $arte = $req->get('arte');
        $politica = $req->get('politica');
        $musica = $req->get('musica');
        $viajar = $req->get('viajar');
        $sexualidad = $req->get('sexualidad');
        // error_log($deporte);
        if (!Persona::find($email)) {
            Persona::create([
                'email' => $email,
                'nombre' => $nombre,
                'pass' => Hash::make($pass),
                'f_nac' => $date,
                'ciudad' => $ciudad,
                'descripcion' => $desc,
                'tipo_relacion' => $tipo_relacion,
                'tieneHijos' => $tieneHijos,
                'quiereHijos' => $quiereHijos,
                'foto' => '/images/prueba/' . rand(1, 32) . '.jpg',
                'conectado' => 0,
                'activo' => 0,
                'tema' => 0,
                'id_genero' => $id_genero
            ]);
            PreferenciaPersona::create([
                'email' => $email,
                'id_preferencia' => 1,
                'intensidad' => $deporte
            ]);
            PreferenciaPersona::create([
                'email' => $email,
                'id_preferencia' => 2,
                'intensidad' => $arte
            ]);
            PreferenciaPersona::create([
                'email' => $email,
                'id_preferencia' => 3,
                'intensidad' => $politica
            ]);
            PreferenciaPersona::create([
                'email' => $email,
                'id_preferencia' => 4,
                'intensidad' => $musica
            ]);
            PreferenciaPersona::create([
                'email' => $email,
                'id_preferencia' => 5,
                'intensidad' => $viajar
            ]);
            if ($sexualidad == 3) {
                GustoGenero::create([
                    'email' => $email,
                    'id_genero' => 1
                ]);
                GustoGenero::create([
                    'email' => $email,
                    'id_genero' => 2
                ]);
            } else {
                GustoGenero::create([
                    'email' => $email,
                    'id_genero' => $sexualidad
                ]);
            }
            RolAsig::create([
                'email' => $email,
                'id_rol' => 1
            ]);
            return response()->json(['mensaje' => 'Insertado con exito'], 200);
        } else {
            return response()->json(['mensaje' => 'error'], 404);
        }
    }

    public function getDatos(string $email)
    {
        $datos = Persona::where('email', '=', $email)
            ->select(['f_nac', 'ciudad', 'descripcion', 'tipo_relacion', 'tieneHijos', 'quiereHijos', 'id_genero'])
            ->first();
        if ($datos) {
            return response()->json($datos, 200);
        } else {
            return response()->json(['mensaje' => 'Error al obtener los usuarios.'], 402);
        }
    }

    public function editarPerfil(Request $request)
    {
        try {
            $emailAntiguo = $request->get('emailAntiguo');
            $relacion = $request->get('relacion');
            $tiene_hijos = $request->get('tiene_hijos');
            $quiere_hijos = $request->get('quiere_hijos');
            $sexo = $request->get('sexo');
            Persona::where('email', $emailAntiguo)
                ->update(
                    [
                        'email' => $request->get('email'),
                        'nombre' => $request->get('nombre'),
                        'f_nac' => $request->get('date'),
                        'ciudad' => $request->get('ciudad'),
                        'descripcion' => $request->get('desc'),
                        'tipo_relacion' => $relacion[0],
                        'tieneHijos' => $tiene_hijos[0],
                        'quiereHijos' => $quiere_hijos[0],
                        'id_genero' => $sexo[0]
                    ]
                );
            $usuario = DB::table('personas')->where('email', $request->get('email'))->first();

            $usuario = $this->getDatosUsuario($usuario);
            $this->sacarDislikes($usuario->email);
            // error_log(print_r($usuario, true));
            return response()->json($usuario, 200);
        } catch (Exception $th) {
            return response()->json(['mensaje' => $th->getMessage()], 400);
        }
    }

    public function cambiarPass(Request $request)
    {
        try {
            // error_log('ey');
            $emailAntiguo = $request->get('emailAntiguo');
            // error_log($dniAntiguo);
            $pass = $request->get('pass');
            // error_log($pass);
            Persona::where('email', $emailAntiguo)
                ->update(['pass' => Hash::make($pass)]);
            return response()->json(['mensaje' => 'Se ha cambiado la contraseña'], 200);
        } catch (Exception $th) {
            return response()->json(['mensaje' => $th->getMessage()], 400);
        }
    }

    public function cerrarSesion(string $email)
    {
        try {
            Persona::where('email', $email)
                ->update(['conectado' => 0]);
            return response()->json(['mensaje' => 'Usuario desconectado'], 200);
        } catch (Exception $th) {
            return response()->json(['mensaje' => $th->getMessage()], 400);
        }
    }

    public function getPreferencias(string $email)
    {
        $datos = PreferenciaPersona::where('email', '=', $email)
            ->select(['id_preferencia', 'intensidad'])
            ->get();
        // error_log(print_r($datos[0]->intensidad, true));

        $gusto = GustoGenero::where('email', '=', $email)
            ->select(['id_genero'])
            ->get();
        // error_log($gusto);
        $preferencias = [
            "deporte" => $datos[0]->intensidad,
            "arte" => $datos[1]->intensidad,
            "politica" => $datos[2]->intensidad,
            "musica" => $datos[3]->intensidad,
            "viajar" => $datos[4]->intensidad,
            "gusto_genero" => $gusto,
        ];
        // error_log(print_r($preferencias, true));
        if ($preferencias) {
            return response()->json($preferencias, 200);
        } else {
            return response()->json(['mensaje' => 'Error al obtener las preferencias.'], 402);
        }
    }

    public function editarPreferencias(Request $request)
    {
        try {
            $emailAntiguo = $request->get('emailAntiguo');
            $deporte = $request->get('deporte');
            $arte = $request->get('arte');
            $politica = $request->get('politica');
            $musica = $request->get('musica');
            $viajar = $request->get('viajar');
            $sexualidad = $request->get('sexualidad');
            PreferenciaPersona::where([['email', $emailAntiguo], ['id_preferencia', 1]])
                ->update(
                    [
                        'intensidad' => $deporte,
                    ]
                );
            PreferenciaPersona::where([['email', $emailAntiguo], ['id_preferencia', 2]])
                ->update(
                    [
                        'intensidad' => $arte,
                    ]
                );
            PreferenciaPersona::where([['email', $emailAntiguo], ['id_preferencia', 3]])
                ->update(
                    [
                        'intensidad' => $politica,
                    ]
                );
            PreferenciaPersona::where([['email', $emailAntiguo], ['id_preferencia', 4]])
                ->update(
                    [
                        'intensidad' => $musica,
                    ]
                );
            PreferenciaPersona::where([['email', $emailAntiguo], ['id_preferencia', 5]])
                ->update(
                    [
                        'intensidad' => $viajar,
                    ]
                );
            GustoGenero::where('email', '=', $emailAntiguo)->delete();
            foreach ($sexualidad as $s) {
                // error_log($s);
                GustoGenero::create(['id_genero' => $s, 'email' => $emailAntiguo]);
            }
            $this->sacarDislikes($emailAntiguo);
            return response()->json(['mensaje' => 'Preferencias actualizadas con éxito.'], 200);
        } catch (Exception $th) {
            return response()->json(['mensaje' => $th->getMessage()], 400);
        }
    }

    public function establecerAfinidades(string $email)
    {
        // error_log($email);
        try {
            $usuarios = Persona::where('email', '!=', $email)
                ->select(['email', 'nombre', 'f_nac', 'ciudad', 'tipo_relacion', 'tieneHijos', 'quiereHijos', 'foto', 'id_genero'])
                ->get();

            // error_log($usuarios[0]->email);
            // error_log(print_r($usuarios, true));
            foreach ($usuarios as $u) {
                // error_log($u);
                $preferencias = PreferenciaPersona::where('email', '=', $u->email)
                    ->select(['id_preferencia', 'intensidad'])
                    ->get();
                $u->preferencias = $preferencias;
                // error_log($u->preferencias[0]);
                $gusto = GustoGenero::where('email', '=', $u->email)
                    ->select(['id_genero'])
                    ->get();
                $u->gusto = $gusto;
                // error_log($u->gusto[0]->id_genero);
            }

            $usuario = Persona::where('email', $email)
                ->select(['email', 'nombre', 'f_nac', 'ciudad', 'tipo_relacion', 'tieneHijos', 'quiereHijos', 'foto', 'id_genero'])
                ->first();
            $preferencias = PreferenciaPersona::where('email', '=', $email)
                ->select(['id_preferencia', 'intensidad'])
                ->get();
            $usuario->preferencias = $preferencias;
            $gusto = GustoGenero::where('email', '=', $email)
                ->select(['id_genero'])
                ->get();
            $usuario->gusto = $gusto;
            // error_log($usuario->gusto[0]);
            Afinidad::where('email1', '=', $email)->delete();
            foreach ($usuarios as $u) {
                $coincide = false;
                $afinidad = 0;
                foreach ($u->gusto as $g) {
                    if ($g->id_genero == $usuario->id_genero) {
                        $coincide = true;
                    }
                }
                if ($coincide) {
                    $coincide = false;
                    foreach ($usuario->gusto as $g) {
                        if ($g->id_genero == $u->id_genero) {
                            $coincide = true;
                        }
                    }
                }
                if ($coincide) {
                    if ($usuario->tipo_relacion == $u->tipo_relacion) {
                        $afinidad = $afinidad + 15;
                    } else {
                        $afinidad = $afinidad - 5;
                    }

                    if ($usuario->ciudad == $u->ciudad) {
                        $afinidad = $afinidad + 20;
                    }

                    if ($usuario->tieneHijos == $u->quiereHijos) {
                        $afinidad = $afinidad + 13;
                    } else {
                        $afinidad = $afinidad - 6;
                    }

                    if ($usuario->quiereHijos == $u->tieneHijos) {
                        $afinidad = $afinidad + 13;
                    } else {
                        $afinidad = $afinidad - 4;
                    }
                    $i = 0;
                    foreach ($usuario->preferencias as $p) {
                        if ($p->intensidad == $u->preferencias[$i]->intensidad) {
                            $afinidad = $afinidad + 20;
                        } else if ($p->intensidad >= $u->preferencias[$i]->intensidad - 10 && $p->intensidad <= $u->preferencias[$i]->intensidad + 10) {
                            $afinidad = $afinidad + 15;
                        } else if ($p->intensidad >= $u->preferencias[$i]->intensidad - 20 && $p->intensidad <= $u->preferencias[$i]->intensidad + 20) {
                            $afinidad = $afinidad + 13;
                        } else if ($p->intensidad >= $u->preferencias[$i]->intensidad - 25 && $p->intensidad <= $u->preferencias[$i]->intensidad + 25) {
                            $afinidad = $afinidad + 10;
                        } else if ($p->intensidad >= $u->preferencias[$i]->intensidad - 35 && $p->intensidad <= $u->preferencias[$i]->intensidad + 35) {
                            $afinidad = $afinidad + 6;
                        } else if ($p->intensidad >= $u->preferencias[$i]->intensidad - 50 && $p->intensidad <= $u->preferencias[$i]->intensidad + 50) {
                            $afinidad = $afinidad + 3;
                        } else if ($p->intensidad >= $u->preferencias[$i]->intensidad - 70 && $p->intensidad <= $u->preferencias[$i]->intensidad + 70) {
                            $afinidad = $afinidad + 1;
                        } else {
                            $afinidad = $afinidad - 4;
                        }
                        $i++;
                    }
                } else {
                    $afinidad = -1000;
                }
                Afinidad::create([
                    'email1' => $email,
                    'email2' => $u->email,
                    'afinidad' => $afinidad,
                ]);
                // error_log($u->email);
                // error_log($afinidad);
            }

            return response()->json(['mensaje' => 'Afinidades establecidas.'], 200);
        } catch (Exception $th) {
            return response()->json(['mensaje' => $th->getMessage()], 400);
        }
    }

    public function getAfines(string $email)
    {
        try {
            // error_log('eeey');
            $likes = Like::where('email_origen', $email)
                ->select(['email_destino'])
                ->pluck('email_destino')
                ->toArray();
            $dislikes = Dislike::where('email_origen', $email)
                ->select(['email_destino'])
                ->pluck('email_destino')
                ->toArray();
            $usuarios = Persona::join('afinidad', 'afinidad.email2', '=', 'personas.email')
                ->whereNotIn('personas.email', $likes)
                ->whereNotIn('personas.email', $dislikes)
                ->where([['personas.email', '!=', $email], ['afinidad.afinidad', '!=', -1000], ['afinidad.email1', '=', $email]])
                ->select(['personas.email', 'personas.nombre', 'personas.f_nac', 'personas.ciudad', 'personas.descripcion', 'personas.tipo_relacion', 'personas.tieneHijos', 'personas.quiereHijos', 'personas.foto', 'personas.id_genero'])
                ->orderBy('afinidad.afinidad', 'desc')
                ->get();

            return response()->json($usuarios, 200);
        } catch (Exception $th) {
            return response()->json(['mensaje' => $th->getMessage()], 400);
        }
        // error_log($usuarios);
    }

    public function like(string $email, string $emailLike)
    {
        try {
            // error_log('eeey');
            Like::create([
                'email_origen' => $email,
                'email_destino' => $emailLike,
            ]);
            return response()->json(['mensaje' => 'Le has dado like a este usuario.'], 200);
        } catch (Exception $th) {
            return response()->json(['mensaje' => $th->getMessage()], 400);
        }
        // error_log($usuarios);
    }

    public function dislike(string $email, string $emailLike)
    {
        try {
            // error_log('eeey');
            Dislike::create([
                'email_origen' => $email,
                'email_destino' => $emailLike,
            ]);

            return response()->json(['mensaje' => 'Le has dado like a este usuario.'], 200);
        } catch (Exception $th) {
            return response()->json(['mensaje' => $th->getMessage()], 400);
        }
        // error_log($usuarios);
    }

    public function sacarDislikes(string $email)
    {
        try {
            Dislike::where('email_destino', '=', $email)->delete();
            // error_log($email);
            return response()->json(['mensaje' => 'Sacado de dislikes.'], 200);
        } catch (Exception $th) {
            return response()->json(['mensaje' => $th->getMessage()], 400);
        }
        // error_log($usuarios);
    }

    public function establecerAmigos(string $email)
    {
        try {
            // error_log($email);
            $likes = Like::where('email_origen', '=', $email)
                ->select(['email_destino'])
                ->get();
            // error_log($likes);
            foreach ($likes as $like) {
                // error_log($like->email_destino);
                $likes2 = Like::where('email_origen', '=', $like->email_destino)
                    ->select(['email_destino'])
                    ->pluck('email_destino')
                    ->toArray();
                // error_log(print_r($likes2, true));
                if (in_array($email, $likes2)) {
                    // error_log($like->email_destino);
                    Amigo::where([['email1',  $email], ['email2',  $like->email_destino]])->delete();
                    Amigo::where([['email1',  $like->email_destino], ['email2',  $email]])->delete();
                    Amigo::create([
                        'email1' => $email,
                        'email2' => $like->email_destino,
                    ]);
                    Amigo::create([
                        'email1' => $like->email_destino,
                        'email2' => $email,
                    ]);
                }
            }
            return response()->json(['mensaje' => 'Amigos establecidos.'], 200);
        } catch (Exception $th) {
            return response()->json(['mensaje' => $th->getMessage()], 400);
        }
        // error_log($usuarios);
    }

    public function getAmigos(string $email)
    {
        try {
            // error_log($email);
            $amigos = Persona::join('amigos', 'amigos.email2', '=', 'personas.email')
                ->where('amigos.email1', $email)
                ->select(['personas.email', 'personas.nombre', 'personas.conectado', 'personas.id_genero'])
                ->get();
            // error_log($amigos);
            return response()->json($amigos, 200);
        } catch (Exception $th) {
            return response()->json(['mensaje' => $th->getMessage()], 400);
        }
        // error_log($usuarios);
    }

    public function borrarAmigo(string $email, string $emailAmigo)
    {
        try {
            Amigo::where([['email1',  $email], ['email2',  $emailAmigo]])->delete();
            Amigo::where([['email1',  $emailAmigo], ['email2',  $email]])->delete();
            Like::where([['email_origen',  $email], ['email_destino',  $emailAmigo]])->delete();
            return response()->json(['mensaje' => 'Usuario borrado.'], 200);
        } catch (Exception $th) {
            return response()->json(['mensaje' => $th->getMessage()], 400);
        }
        // error_log($usuarios);
    }

    public function getMensajes(string $email, string $emailMensaje)
    {
        try {
            $mensajes = Mensaje::where([['email_origen',  $emailMensaje], ['email_destino',  $email]])
                ->select(['email_origen', 'email_destino', 'texto', 'leido'])
                ->get();
            // error_log($mensajes);
            return response()->json($mensajes, 200);
        } catch (Exception $th) {
            return response()->json(['mensaje' => $th->getMessage()], 400);
        }
        // error_log($usuarios);
    }

    public function enviarMensaje(Request $request)
    {
        try {
            Mensaje::create([
                'email_origen' => $request->email_origen,
                'email_destino' => $request->email_destino,
                'texto' => $request->texto,
                'leido' => 0,
            ]);
            // error_log('eee');
            return response()->json(['mensaje' => 'Mensaje enviado.'], 200);
        } catch (Exception $th) {
            return response()->json(['mensaje' => $th->getMessage()], 400);
        }
        // error_log($usuarios);
    }
}
