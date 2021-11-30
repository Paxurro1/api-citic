<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmigo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amigos', function (Blueprint $table) {
            $table->string('email1');
            $table->string('email2');
            $table->primary(['email1', 'email2']);
            $table->foreign('email1')->references('email')->on('personas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('email2')->references('email')->on('personas')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('amigo');
    }
}
