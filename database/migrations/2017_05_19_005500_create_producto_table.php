<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoTable extends Migration
{
   public function up(){
      Schema::create('producto', function (Blueprint $table){
        	$table->increments('id');
        	$table->string('tipo_creador');
       		$table->integer('creador_id');
        	$table->string('nombre');
        	$table->string('nombre_seo')->nullable();
        	$table->text('descripcion')->nullable();
		   	  $table->integer('pais_id');
        	$table->integer('bebida_id');
        	$table->integer('clase_bebida_id');
        	$table->integer('marca_id');
        	$table->string('imagen')->nullable();
        	$table->integer('ano_produccion')->nullable();
       		$table->boolean('publicado');
         	$table->boolean('confirmado');
       		$table->timestamps();

         $table->foreign('pais_id')
               ->references('id')->on('pais')
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

		Schema::create('importador_producto', function (Blueprint $table){
			$table->increments('id');
			$table->integer('importador_id');
			$table->integer('producto_id');
			$table->timestamps();

			$table->foreign('importador_id')
               ->references('id')->on('importador')
               ->onDelete('restrict')
               ->onUpdate('cascade');

         $table->foreign('producto_id')
               ->references('id')->on('producto')
               ->onDelete('restrict')
               ->onUpdate('cascade');
		});

		Schema::create('distribuidor_producto', function (Blueprint $table){
			$table->increments('id');
			$table->integer('distribuidor_id');
			$table->integer('producto_id');
			$table->timestamps();

			$table->foreign('distribuidor_id')
                  ->references('id')->on('distribuidor')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

         $table->foreign('producto_id')
               ->references('id')->on('producto')
               ->onDelete('restrict')
               ->onUpdate('cascade');
		});

		Schema::create('horeca_producto', function (Blueprint $table){
			$table->increments('id');
			$table->integer('horeca_id');
			$table->integer('producto_id');
			$table->timestamps();

			$table->foreign('horeca_id')
                  ->references('id')->on('horeca')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

         $table->foreign('producto_id')
               ->references('id')->on('producto')
               ->onDelete('restrict')
               ->onUpdate('cascade');
		});
    }

    public function down()
    {
        Schema::dropIfExists('producto');
        Schema::dropIfExists('importador_producto');
        Schema::dropIfExists('distribuidor_producto');
        Schema::dropIfExists('horeca_producto');
    }
}
