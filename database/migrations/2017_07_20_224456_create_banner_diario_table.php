<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannerDiarioTable extends Migration
{
    public function up()
    {
        Schema::create('banner_diario', function (Blueprint $table){
            $table->increments('id');
            $table->integer('banner_id');
            $table->integer('pais_id');
            $table->date('fecha');
            $table->timestamps();

            $table->foreign('banner_id')
                  ->references('id')->on('banner')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('pais_id')
                  ->references('id')->on('pais')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('banner_diario');
    }
}
