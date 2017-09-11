<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannerTable extends Migration
{
    public function up()
    {
        Schema::create('banner', function (Blueprint $table){
            $table->increments('id');
            $table->integer('creador_id');
            $table->string('tipo_creador');
            $table->string('titulo');
            $table->string('imagen');
            $table->string('url_banner');
            $table->text('descripcion');
            $table->integer('aprobado');
            $table->text('correcciones')->nullable();
            $table->boolean('admin');            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('banner');
    }
}
