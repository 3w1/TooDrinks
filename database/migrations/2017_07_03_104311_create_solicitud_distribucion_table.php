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
            $table->integer('producto_id');
            $table->integer('provincia_region_id');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('producto_id')
                  ->references('id')->on('producto')
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
