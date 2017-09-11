<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacionITable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacion_i', function (Blueprint $table){
            $table->increments('id');
            $table->integer('creador_id');
            $table->string('tipo_creador');
            $table->integer('importador_id');
            $table->string('tipo');
            $table->string('titulo');
            $table->string('url');
            $table->string('descripcion');
            $table->string('color');
            $table->string('icono');
            $table->date('fecha');
            $table->boolean('leida');
            $table->timestamps();

             $table->foreign('importador_id')
                  ->references('id')->on('importador')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('notificacion_i');
    }
}
