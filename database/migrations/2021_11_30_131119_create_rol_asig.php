<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolAsig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_asignados', function (Blueprint $table) {
            $table->string('email');
            $table->unsignedBigInteger('id_rol');
            $table->primary(['email', 'id_rol']);
            $table->foreign('email')->references('email')->on('personas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_rol')->references('id')->on('roles')->onDelete('cascade');
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
        Schema::dropIfExists('rol_asig');
    }
}
