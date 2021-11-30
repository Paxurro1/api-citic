<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAfinidad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('afinidad', function (Blueprint $table) {
            $table->string('email1');
            $table->string('email2');
            $table->primary(['email1', 'email2']);
            $table->foreign('email1')->references('email')->on('personas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('email2')->references('email')->on('personas')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('afinidad');
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
        Schema::dropIfExists('afinidad');
    }
}
