<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscenariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escenarios', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('idAventura')->unsigned();
            $table->foreign('idAventura')->references('id')->on('aventuras');
            $table->string('nombre');
            $table->boolean('activo');
            $table->string('imagen');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('escenarios');
    }
}
