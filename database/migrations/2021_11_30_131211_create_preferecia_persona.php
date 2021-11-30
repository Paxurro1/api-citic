<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrefereciaPersona extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preferecia_personas', function (Blueprint $table) {
            $table->string('email');
            $table->unsignedBigInteger('id_preferencia');
            $table->primary(['email', 'id_preferencia']);
            $table->integer('intensidad');
            $table->foreign('email')->references('email')->on('personas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_preferencia')->references('id')->on('preferencias')->onDelete('cascade');
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
        Schema::dropIfExists('preferecia_persona');
    }
}
