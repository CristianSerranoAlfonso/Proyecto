<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelEntidadHabilidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidad_habilidad', function (Blueprint $table) {
            $table->bigInteger('entidad_id')->unsigned();
            $table->foreign('entidad_id')->references('id')->on('entidades');
            $table->bigInteger('habilidad_id')->unsigned();
            $table->foreign('habilidad_id')->references('id')->on('habilidades');
            $table->primary(['entidad_id', 'habilidad_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entidad_habilidad');
    }
}
