<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistribuidorDemandaProductoTable extends Migration
{

    public function up()
    {
        Schema::create('distribuidor_demanda_producto', function (Blueprint $table){
            $table->increments('id');
            $table->integer('distribuidor_id');
            $table->integer('demanda_producto_id');
            $table->date('fecha');
            $table->timestamps();

            $table->foreign('distribuidor_id')
                  ->references('id')->on('distribuidor')
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
        Schema::dropIfExist('distribuidor_demanda_producto');
    }
}
