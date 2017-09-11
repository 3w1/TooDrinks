<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacionAdminTable extends Migration
{

    public function up()
    {
        Schema::create('notificacion_admin', function (Blueprint $table){
            $table->increments('id');
            $table->integer('creador_id');
            $table->enum('tipo_creador');
            $table->integer('admin_id');
            $table->string('tipo');
            $table->string('titulo');
            $table->string('url');
            $table->string('descripcion');
            $table->string('color');
            $table->string('icono');
            $table->date('fecha');
            $table->boolean('leida');
            $table->timestamps();

             $table->foreign('admin_id')
                  ->references('id')->on('admin')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExist('notificacion_admin');
    }
}
