<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelEnemigoEscenariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enemigo_escenario', function (Blueprint $table) {
            $table->bigInteger('enemigo_id')->unsigned();
            $table->foreign('enemigo_id')->references('id')->on('enemigos');
            $table->bigInteger('escenario_id')->unsigned();
            $table->foreign('escenario_id')->references('id')->on('escenarios');
            $table->primary(['enemigo_id', 'escenario_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enemigo_escenario');
    }
}
