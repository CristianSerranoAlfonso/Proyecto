<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnemigosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enemigos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idEntidad')->unsigned();
            $table->foreign('idEntidad')->references('id')->on('entidades');
            $table->integer('fuerza');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enemigos');
    }
}
