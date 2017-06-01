<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistribuidorTable extends Migration
{
    public function up()
    {
        Schema::create('distribuidor', function (Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->string('nombre');
            $table->string('nombre_seo');
            $table->text('descripcion');
            $table->text('direccion');
            $table->integer('codigo_postal');
            $table->integer('pais_id');
            $table->integer('provincia_region_id');
            $table->string('logo');
            $table->string('persona_contacto');
            $table->string('telefono');
            $table->string('telefono_opcional')->nullable(); 
            $table->string('email')->unique();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->boolean('reclamada');
            $table->double('latitud', 10, 8);
            $table->double('longitud', 10, 8);
            $table->boolean('estado_datos');
            $table->string('tipo_suscripcion');
            $table->integer('saldo');
            $table->timestamps();

            $table->foreign('user_id')
      			  ->references('id')->on('users')
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

		Schema::create('productor_distribuidor', function (Blueprint $table){
			$table->increments('id');
			$table->integer('productor_id');
			$table->integer('distribuidor_id');
			$table->timestamps();

			$table->foreign('productor_id')
      			  ->references('id')->on('productor')
      			  ->onDelete('restrict')
      			  ->onUpdate('cascade');

      		$table->foreign('distribuidor_id')
      			  ->references('id')->on('distribuidor')
      			  ->onDelete('restrict')
      			  ->onUpdate('cascade');
		});

		Schema::create('importador_distribuidor', function (Blueprint $table){
			$table->increments('id');
			$table->integer('importador_id');
			$table->integer('distribuidor_id');
			$table->timestamps();

			$table->foreign('importador_id')
      			  ->references('id')->on('importador')
      			  ->onDelete('restrict')
      			  ->onUpdate('cascade');

      		$table->foreign('distribuidor_id')
      			  ->references('id')->on('distribuidor')
      			  ->onDelete('restrict')
      			  ->onUpdate('cascade');
		});
    }

    public function down()
    {
        Schema::dropIfExists('distribuidor');
        Schema::dropIfExists('productor_distribuidor');
        Schema::dropIfExists('importador_distribuidor');
    }
}
