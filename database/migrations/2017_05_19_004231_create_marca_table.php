<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarcaTable extends Migration
{
    public function up()
    {
    	Schema::create('marca', function(Blueprint $table){
            $table->increments('id');
            $table->integer('productor_id');
            $table->integer('creador_id');
            $table->enum('tipo_creador', ['P', 'I', 'D', 'U', 'AD', 'SA']);
            $table->string('nombre');
            $table->string('nombre_seo');
            $table->text('descripcion');
            $table->integer('pais_id');
            $table->integer('provincia_region_id');
            $table->string('logo');
            $table->string('website')->nullable();
            $table->boolean('reclamada');
            $table->boolean('publicada');
            $table->timestamps();

          	$table->foreign('productor_id')
      			  ->references('id')->on('productor')
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

      	Schema::create('importador_marca', function (Blueprint $table){
      		$table->increments('id');
      		$table->integer('importador_id');
      		$table->integer('marca_id');
           	$table->boolean('status');
      		$table->timestamps();

      		$table->foreign('importador_id')
       			  ->references('id')->on('importador')
       			  ->onDelete('restrict')
          		  ->onUpdate('cascade');

          	$table->foreign('marca_id')
          		  ->references('id')->on('marca')
       			  ->onDelete('restrict')
       			  ->onUpdate('cascade');
    	});

		Schema::create('distribuidor_marca', function (Blueprint $table){
			$table->increments('id');
			$table->integer('distribuidor_id');
			$table->integer('marca_id');
      		$table->boolean('status');
			$table->timestamps();

  			$table->foreign('distribuidor_id')
        			  ->references('id')->on('distribuidor')
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
        Schema::dropIfExists('marca');
        Schema::dropIfExists('distribuidor_marca');
        Schema::dropIfExists('importador_marca');
    }
}
