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
Route::group(['prefix' => 'user'], function () {
    Route::post('loging',[controladorUsuario::class,'loging']);
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('listarUsuarios',[controladorAdministradores::class,'listadoUsuarios']);
});
