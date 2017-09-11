<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductorSolicitudImportacionTable extends Migration
{
    public function up()
    {
        Schema::create('productor_solicitud_importacion', function (Blueprint $table){
            $table->increments('id');
            $table->integer('productor_id');
            $table->integer('solicitud_importacion_id');
            $table->date('fecha');
            $table->boolean('marcada');
            $table->timestamps();

            $table->foreign('productor_id')
                  ->references('id')->on('productor')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('solicitud_importacion_id')
                  ->references('id')->on('solicitud_importacion')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExist('productor_solicitud_importacion');
    }
}
