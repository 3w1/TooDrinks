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
            $table->integer('producto_id');
            $table->integer('bebida_id');
            $table->enum('tipo_creador', ['I','D','H']);
            $table->integer('creador_id');
            $table->integer('pais_id');
            $table->integer('provincia_region_id');
            $table->string('titulo');
            $table->text('descripcion');
            $table->integer('cantidad_minima')->default(0);
            $table->integer('cantidad_maxima')->defautl(0);
            $table->date('fecha_creacion');
            $table->date('fecha_caducidad');
            $table->boolean('status');
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

            $table->foreign('provincia_region_id')
                  ->references('id')->on('provincia_region')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('demanda_producto');
    }
}
