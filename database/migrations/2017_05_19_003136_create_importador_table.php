<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportadorTable extends Migration
{
    public function up()
    {
        Schema::create('importador', function (Blueprint $table){
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
            $table->string('email')->unique();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->enum('reclamada', ['Si', 'No' ])->default('No');
            $table->double('latitud', 10, 8);
            $table->double('longitud', 10, 8);
            $table->enum('estado_datos', ['Actualizados', 'Sin Actualizar']);
            $table->string('tipo_suscripcion');
            $table->integer('saldo');
            $table->timestamps();

            $table->foreign('user_id')
      			  ->references('id')->on('user')
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

		Schema::create('productor_importador', function (Blueprint $table){
			$table->increments('id');
			$table->integer('productor_id');
			$table->integer('importador_id');
			$table->timestamps();

			$table->foreign('productor_id')
      			  ->references('id')->on('productor')
      			  ->onDelete('restrict')
      			  ->onUpdate('cascade');

      		$table->foreign('importador_id')
      			  ->references('id')->on('importador')
      			  ->onDelete('restrict')
      			  ->onUpdate('cascade');
		});
    }

    public function down()
    {
        Schema::dropIfExists('importador');
        Schema::dropIfExists('productor_importador');
    }
}
