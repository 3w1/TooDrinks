<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMultinacionalDemandaProductoTable extends Migration
{
    public function up()
    {
        Schema::create('multinacional_demanda_producto', function (Blueprint $table){
            $table->increments('id');
            $table->integer('multinacional_id');
            $table->integer('demanda_producto_id');
            $table->date('fecha');
            $table->timestamps();

            $table->foreign('multinacional_id')
                  ->references('id')->on('multinacional')
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
        Schema::dropIfExists('multinacional_demanda_producto');
    }
}
