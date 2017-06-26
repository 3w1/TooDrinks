<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoTable extends Migration
{
    public function up()
    {
        Schema::create('producto', function (Blueprint $table){
        	$table->increments('id');
        	$table->string('nombre');
        	$table->string('nombre_seo');
        	$table->text('descripcion');
          $table->integer('pais_id');
        	$table->integer('provincia_region_id');
        	$table->integer('clase_bebida_id');
          $table->integer('bebida_id');
        	$table->integer('marca_id');
        	$table->string('imagen');
        	$table->integer('ano_produccion');
          $table->enum('tipo_creador', ['U', 'P', 'I', 'D']);
          $table->integer('creador_id');
          $table->boolean('publicado')->default(1);
          $table->boolean('confirmado')->default(0);
          $table->timestamps();

            $table->foreign('pais_id')
                  ->references('id')->on('pais')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('provincia_region_id')
                  ->references('id')->on('provincia_region')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('clase_bebida_id')
                  ->references('id')->on('clase_bebida')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('bebida_id')
                  ->references('id')->on('bebida')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');    

            $table->foreign('marca_id')
                  ->references('id')->on('marca')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('producto');
    }
}
