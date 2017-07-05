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
            $table->integer('producto_id');
            $table->integer('pais_id');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('producto_id')
                  ->references('id')->on('producto')
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
