<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAventurasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aventuras', function (Blueprint $table) {
            $table->bigInteger('idAventura')->unsignded();
            $table->bigInteger('idUsuario')->unsigned();
            $table->foreign('idUsuario')->references('id')->on('usuarios');
            $table->string('nombre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aventuras');
    }
}
