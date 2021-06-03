<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiradas', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement()->unsigned();
            $table->bigInteger('idEscenario')->unsigned();
            $table->bigInteger('idEntidad')->unsigned();
            $table->bigInteger('idHabilidad')->unsigned();
            $table->string('comentario');
            $table->integer('tirada');
            $table->string('fecha');
            $table->foreign('idEscenario')->references('id')->on('escenarios');
            $table->foreign('idEntidad')->references('id')->on('entidades');
            $table->foreign('idHabilidad')->references('id')->on('habilidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiradas');
    }
}
