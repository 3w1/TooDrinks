<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductorDemandaProductoTable extends Migration
{

    public function up()
    {
        Schema::create('productor_demanda_producto', function (Blueprint $table){
            $table->increments('id');
            $table->integer('productor_id');
            $table->integer('demanda_producto_id');
            $table->date('fecha');
            $table->boolean('marcada');
            $table->timestamps();

            $table->foreign('productor_id')
                  ->references('id')->on('productor')
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
        Schema::dropIfExist('productor_demanda_producto');
    }
}
