<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjetosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objetos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('rango');
            $table->string('tipo');
            $table->integer('armadura');
            $table->integer('fuerza');
            $table->integer('destreza');
            $table->integer('inteligencia');
            $table->integer('cordura');
            $table->integer('sabiduria');
            $table->integer('evasion');
            $table->integer('precio');
            $table->mediumtext('descripcion');
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
        Schema::dropIfExists('objetos');
    }
}
