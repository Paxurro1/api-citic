<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMensaje extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->string('email_origen');
            $table->foreign('email_origen')->references('email')->on('personas')->onUpdate('cascade');
            $table->string('email_destino');
            $table->foreign('email_destino')->references('email')->on('personas')->onUpdate('cascade');
            $table->string('texto',1000);
            $table->integer('leido');
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
        Schema::dropIfExists('mensaje');
    }
}
