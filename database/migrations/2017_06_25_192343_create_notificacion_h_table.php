<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacionHTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacion_h', function (Blueprint $table){
            $table->increments('id');
            $table->integer('creador_id');
            $table->enum('tipo_creador', ['P', 'I', 'D', 'H', 'U']);
            $table->integer('horeca_id');
            $table->string('titulo');
            $table->string('url');
            $table->string('descripcion');
            $table->string('color');
            $table->string('icono');
            $table->timestamps();

             $table->foreign('horeca_id')
                  ->references('id')->on('horeca')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('notifiacion_h');
    }
}
