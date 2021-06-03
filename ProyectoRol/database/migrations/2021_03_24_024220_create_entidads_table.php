<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidades', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->bigInteger('idUsuario')->unsigned();
            $table->foreign('idUsuario')->references('id')->on('users');
            $table->string('nombre')->unique;
            $table->string('sexo');
            $table->string('deidad');
            $table->integer('vida');
            $table->integer('precision');
            $table->integer('evasion');
            $table->string('efectoNegativo1');
            $table->integer('baseEfectoNegativo1');
            $table->string('efectoNegativo2');
            $table->integer('baseEfectoNegativo2');
            $table->string('efectoPositivo1');
            $table->integer('baseEfectoPositivo1');
            $table->string('efectoPositivo2');
            $table->integer('baseEfectoPositivo2');
            $table->integer('posX');
            $table->integer('posY');
            $table->mediumtext('historia');
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
        Schema::dropIfExists('entidades');
    }
}
