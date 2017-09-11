<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistribuidorOfertaTable extends Migration
{
    public function up()
    {
        Schema::create('distribuidor_oferta', function (Blueprint $table){
            $table->increments('id');
            $table->integer('distribuidor_id');
            $table->integer('oferta_id');
            $table->date('fecha');
            $table->boolean('marcada');
            $table->timestamps();

            $table->foreign('distribuidor_id')
                  ->references('id')->on('distribuidor')
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
        Schema::dropIfExist('distribuidor_oferta');
    }
}
