<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personajes', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->bigInteger('idEntidad')->unsigned();
            $table->foreign('idEntidad')->references('id')->on('entidades');
            $table->integer('nivel');
            $table->boolean('turno');
            $table->integer('armadura');
            $table->integer('fuerza');
            $table->integer('destreza');
            $table->integer('inteligencia');
            $table->integer('cordura');
            $table->integer('carisma');
            $table->integer('sabiduria');
            $table->string('caracteristica1');
            $table->string('caracteristica2');
            $table->string('caracteristica3');
            $table->integer('dinero');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personajes');
    }
}
