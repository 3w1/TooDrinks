<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpinionTable extends Migration
{
    public function up()
    {
        Schema::create('opinion', function (Blueprint $table){
        	$table->increments('id');
          $table->enum('tipo_creador', ['U','P','I','D','H']);
        	$table->integer('creador_id');
        	$table->integer('producto_id');
        	$table->integer('valoracion');
        	$table->string('comentario');
        	$table->date('fecha');
        	$table->boolean('editada');
        	$table->date('fecha_ultima_edicion')_>nullable();
        	$table->boolean('publicada');
         	$table->timestamps();

          	$table->foreign('producto_id')
                  ->references('id')->on('producto')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('opinion');
    }
}
