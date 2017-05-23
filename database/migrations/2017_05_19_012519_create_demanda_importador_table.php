<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandaImportadorTable extends Migration
{
    public function up()
    {
        Schema::create('demanda_importador', function (Blueprint $table){
        	$table->increments('id');
        	$table->integer('productor_id');
        	$table->integer('producto_id');
        	$table->integer('pais_id');
        	$table->integer('provincia_region_id');
          $table->enum('status', ['Activa', 'Inactiva']);
          $table->timestamps();

            $table->foreign('producto_id')
                  ->references('id')->on('producto')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('productor_id')
                  ->references('id')->on('productor')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('pais_id')
                  ->references('id')->on('pais')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('provincia_region_id')
                  ->references('id')->on('provincia_region')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('demanda_importador');
    }
}
