<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportadorDemandaProductoTable extends Migration
{
    public function up()
    {
        Schema::create('importador_demanda_producto', function (Blueprint $table){
            $table->increments('id');
            $table->integer('importador_id');
            $table->integer('demanda_producto_id');
            $table->date('fecha');
            $table->boolean('marcada');
            $table->timestamps();

            $table->foreign('importador_id')
                  ->references('id')->on('importador')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('demanda_producto_id')
                  ->references('id')->on('demanda_producto')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('importador_demanda_producto');
    }
}
