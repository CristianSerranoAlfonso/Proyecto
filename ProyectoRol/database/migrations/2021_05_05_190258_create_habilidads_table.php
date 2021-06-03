<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHabilidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habilidades', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement()->unsigned();
            $table->string('nombre')->unique;
            $table->string('facultadNegativa');
            $table->integer('baseFacultadNegativa');
            $table->string('facultadPositiva');
            $table->integer('nivelHabilidad');
            $table->integer('dado');
            $table->integer('valorBase');
            $table->boolean('ataque');
            $table->boolean('area');
            $table->bigInteger('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('habilidades');
    }
}
