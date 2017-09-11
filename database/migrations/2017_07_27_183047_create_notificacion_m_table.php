<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacionMTable extends Migration
{

    public function up()
    {
        Schema::create('notificacion_m', function (Blueprint $table){
            $table->increments('id');
            $table->integer('creador_id');
            $table->string('tipo_creador');
            $table->integer('multinacional_id');
            $table->string('tipo');
            $table->string('titulo');
            $table->string('url');
            $table->string('descripcion');
            $table->string('color');
            $table->string('icono');
            $table->date('fecha');
            $table->boolean('leida');
            $table->timestamps();

             $table->foreign('multinacional_id')
                  ->references('id')->on('multinacional')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notificacion_m');
    }
}
