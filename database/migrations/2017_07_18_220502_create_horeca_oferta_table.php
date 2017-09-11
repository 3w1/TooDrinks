<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorecaOfertaTable extends Migration
{

    public function up()
    {
        Schema::create('horeca_oferta', function (Blueprint $table){
            $table->increments('id');
            $table->integer('horeca_id');
            $table->integer('oferta_id');
            $table->date('fecha');
            $table->boolean('marcada');
            $table->timestamps();

            $table->foreign('horeca_id')
                  ->references('id')->on('horeca')
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
        Schema::dropIfExist('horeca_oferta');
    }
}
