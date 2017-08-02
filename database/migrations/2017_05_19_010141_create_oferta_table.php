<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfertaTable extends Migration
{
    public function up()
    {
        Schema::create('oferta', function (Blueprint $table){
        	$table->increments('id');
        	$table->integer('producto_id');
          $table->enum('tipo_creador', ['P','I','D','M']);
        	$table->integer('creador_id');
        	$table->string('titulo');
        	$table->text('descripcion');
        	$table->double('precio_unitario', 6, 2);
        	$table->double('precio_lote', 6, 2 );
        	$table->integer('cantidad_producto')->nullable();
        	$table->integer('cantidad_caja')->nullable();
        	$table->integer('cantidad_minima')->nullable();
        	$table->boolean('envio');
        	$table->double('costo_envio', 6, 2)->nullable();
          $table->boolean('visible_importadores');
        	$table->boolean('visible_distribuidores');
        	$table->boolean('visible_horecas');
        	$table->integer('cantidad_visitas');
        	$table->integer('cantidad_contactos');
        	$table->date('fecha');
          $table->boolean('status');
          $table->timestamps();

            $table->foreign('producto_id')
                  ->references('id')->on('producto')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        Schema::create('destino_oferta', function (Blueprint $table){
            $table->increments('id');
            $table->integer('oferta_id');
            $table->integer('pais_id');
            $table->integer('provincia_region_id');
            $table->timestamps();

            $table->foreign('pais_id')
                  ->references('id')->on('pais')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('provincia_region_id')
                  ->references('id')->on('provincia_region')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('oferta_id')
                  ->references('id')->on('oferta')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('oferta_productor');
        Schema::dropIfExists('destino_oferta_productor');
    }
}
