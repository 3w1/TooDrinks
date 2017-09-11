<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportadorSolicitudDistribucionTable extends Migration
{
    public function up()
    {
        Schema::create('importador_solicitud_distribucion', function (Blueprint $table){
            $table->increments('id');
            $table->integer('importador_id');
            $table->integer('solicitud_distribucion_id');
            $table->date('fecha');
            $table->boolean('marcada');
            $table->timestamps();

            $table->foreign('importador_id')
                  ->references('id')->on('importador')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('solicitud_distribucion_id')
                  ->references('id')->on('solicitud_distribucion')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExist('importador_solicitud_distribucion');
    }
}
