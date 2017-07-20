<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportadorDemandaImportadorTable extends Migration
{
    public function up()
    {
        Schema::create('importador_demanda_importador', function (Blueprint $table){
            $table->increments('id');
            $table->integer('importador_id');
            $table->integer('demanda_importador_id');
            $table->date('fecha');
            $table->timestamps();

            $table->foreign('importador_id')
                  ->references('id')->on('importador')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('demanda_importador_id')
                  ->references('id')->on('demanda_importador')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExist('importador_demanda_importador');
    }
}
