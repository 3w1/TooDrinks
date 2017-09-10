<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudImportacionTable extends Migration
{

    public function up()
    {
        Schema::create('solicitud_importacion', function (Blueprint $table){
            $table->increments('id');
            $table->integer('importador_id');
            $table->integer('marca_id')->nullable();
            $table->integer('bebida_id')->nullable();
            $table->integer('pais_id')->nullable();
            $table->boolean('status');
            $table->date('fecha');
            $table->integer('cantidad_visitas');
            $table->integer('cantidad_contactos');
            $table->timestamps();

            $table->foreign('bebida_id')
                  ->references('id')->on('bebida')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('marca_id')
                  ->references('id')->on('marca')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('importador_id')
                  ->references('id')->on('importador')
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
        Schema::dropIfExists('solicitud_importacion');
    }
}
