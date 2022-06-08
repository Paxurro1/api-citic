<?php

use App\Http\Controllers\controladorAdministradores;
use App\Http\Controllers\controladorUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => ['Cors']], function () {
    //Login
    Route::post('login',[controladorUsuario::class,'login']);
    //Registro
    Route::post('registro',[controladorUsuario::class,'registro']);

    //Admin
    // Gestión de usuarios
    Route::get('getUsuarios',[controladorAdministradores::class,'getUsuarios']);
    Route::post('addUsuario',[controladorAdministradores::class,'addUsuario']);
    Route::post('/editarUsuario', [controladorAdministradores::class, 'editarUsuario']);
    Route::delete('/borrarUsuario/{email}', [controladorAdministradores::class, 'borrarUsuario']);

    //Usuario
    // Editar perfil
    Route::get('getDatos/{email}',[controladorUsuario::class,'getDatos']);
    Route::post('/editarPerfil', [controladorUsuario::class, 'editarPerfil']);
    Route::post('/cambiarPass', [controladorUsuario::class, 'cambiarPass']);
    Route::get('cerrarSesion/{email}',[controladorUsuario::class,'cerrarSesion']);
    Route::get('getPreferencias/{email}',[controladorUsuario::class,'getPreferencias']);
    Route::post('/editarPreferencias', [controladorUsuario::class, 'editarPreferencias']);
    // Personas afines
    Route::get('establecerAfinidades/{email}',[controladorUsuario::class,'establecerAfinidades']);
    Route::get('getAfines/{email}',[controladorUsuario::class,'getAfines']);
    Route::get('like/{email}/{emailLike}',[controladorUsuario::class,'like']);
    Route::get('dislike/{email}/{emailLike}',[controladorUsuario::class,'dislike']);
    // Amigos
    Route::get('establecerAmigos/{email}',[controladorUsuario::class,'establecerAmigos']);
    Route::get('getAmigos/{email}',[controladorUsuario::class,'getAmigos']);
    Route::get('borrarAmigo/{email}/{emailAmigo}',[controladorUsuario::class,'borrarAmigo']);
});
