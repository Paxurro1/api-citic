<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersona extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('nombre');
            $table->string('pass');
            $table->date('f_nac');
            $table->string('ciudad');
            $table->string('descripcion');
            $table->string('tipo_relacion');
            $table->integer('tieneHijos');
            $table->integer('quiereHijos');
            $table->string('foto');
            $table->integer('conectado');
            $table->integer('activo');
            $table->integer('tema');
            $table->unsignedBigInteger('id_genero');
            $table->foreign('id_genero')->references('id')->on('generos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persona');
    }
}
