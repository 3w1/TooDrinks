<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacionUTable extends Migration
{

    public function up()
    {
         Schema::create('notificacion_u', function (Blueprint $table){
            $table->increments('id');
            $table->integer('creador_id');
            $table->enum('tipo_creador');
            $table->integer('user_id');
            $table->string('tipo');
            $table->string('titulo');
            $table->string('url');
            $table->string('descripcion');
            $table->string('color');
            $table->string('icono');
            $table->date('fecha');
            $table->boolean('leida');
            $table->timestamps();

             $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notificacion_u');
    }
}
