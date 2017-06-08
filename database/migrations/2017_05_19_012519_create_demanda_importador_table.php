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
        	$table->integer('marca_id');
        	$table->integer('pais_id');
          $table->boolean('status');
          $table->timestamps();

            $table->foreign('marca_id')
                  ->references('id')->on('marca')
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
        });
    }

    public function down()
    {
        Schema::dropIfExists('demanda_importador');
    }
}
