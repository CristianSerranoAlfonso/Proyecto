<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelObjetoEntidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objetos_entidad', function (Blueprint $table) {
            $table->bigInteger('entidad_id')->unsigned();
            $table->foreign('entidad_id')->references('id')->on('entidades')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('objeto_id')->unsigned();
            $table->foreign('objeto_id')->references('id')->on('objetos')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['entidad_id', 'objeto_id']);

            
        });
    } 

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rel_objeto_entidads');
    }
}
