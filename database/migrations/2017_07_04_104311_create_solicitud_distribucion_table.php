<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudDistribucionTable extends Migration
{
    public function up()
    {
        Schema::create('solicitud_distribucion', function (Blueprint $table){
            $table->increments('id');
            $table->integer('distribuidor_id');
            $table->integer('marca_id')->nullable();
            $table->integer('bebida_id')->nullable();
            $table->integer('provincia_region_id');
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

            $table->foreign('distribuidor_id')
                  ->references('id')->on('distribuidor')
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
        Schema::dropIfExists('solicitud_distribucion');
    }
}
