<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacionDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacion_d', function (Blueprint $table){
            $table->increments('id');
            $table->integer('creador_id');
            $table->string('tipo_creador');
            $table->integer('distribuidor_id');
            $table->string('tipo');
            $table->string('titulo');
            $table->string('url');
            $table->string('descripcion');
            $table->string('color');
            $table->string('icono');
            $table->date('fecha');
            $table->boolean('leida');
            $table->timestamps();

             $table->foreign('distribuidor_id')
                  ->references('id')->on('distribuidor')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
         Schema::dropIfExists('notificacion_d');
    }
}
