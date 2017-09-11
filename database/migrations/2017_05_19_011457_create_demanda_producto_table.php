<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandaProductoTable extends Migration
{
    public function up()
    {
        Schema::create('demanda_producto', function(Blueprint $table){
            $table->increments('id');
            $table->integer('producto_id')->nullable();
            $table->integer('bebida_id')->nullable();
            $table->integer('pais_id')->nullable();
            $table->string('tipo_creador');
            $table->integer('creador_id');
            $table->string('titulo');
            $table->text('descripcion');
            $table->integer('cantidad_minima')->nullable();
            $table->integer('cantidad_maxima')->nullable();
            $table->date('fecha_creacion');
            $table->boolean('status');
            $table->integer('cantidad_visitas');
            $table->integer('cantidad_contactos');
            $table->timestamps();

            $table->foreign('producto_id')
                  ->references('id')->on('producto')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('bebida_id')
                  ->references('id')->on('bebida')
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
        Schema::dropIfExists('demanda_producto');
    }
}
