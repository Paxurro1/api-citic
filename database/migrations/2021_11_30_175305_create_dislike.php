<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDislike extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dislikes', function (Blueprint $table) {
            $table->string('email_origen');
            $table->string('email_destino');
            $table->primary(['email_origen', 'email_destino']);
            $table->foreign('email_origen')->references('email')->on('personas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('email_destino')->references('email')->on('personas')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('dislike');
    }
}
