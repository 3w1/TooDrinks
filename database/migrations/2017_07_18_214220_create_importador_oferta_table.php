<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportadorOfertaTable extends Migration
{

    public function up()
    {
        Schema::create('importador_oferta', function (Blueprint $table){
            $table->increments('id');
            $table->integer('importador_id');
            $table->integer('oferta_id');
            $table->date('fecha');
            $table->timestamps();

            $table->foreign('importador_id')
                  ->references('id')->on('importador')
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
        Schema::dropIfExist('importador_oferta');
    }
}
