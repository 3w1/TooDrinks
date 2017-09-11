<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistribuidorDemandaDistribuidorTable extends Migration
{
    public function up()
    {
        Schema::create('distribuidor_demanda_distribuidor', function (Blueprint $table){
            $table->increments('id');
            $table->integer('distribuidor_id');
            $table->integer('demanda_distribuidor_id');
            $table->date('fecha');
            $table->boolean('marcada');
            $table->timestamps();

            $table->foreign('distribuidor_id')
                  ->references('id')->on('distribuidor')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('demanda_distribuidor_id')
                  ->references('id')->on('demanda_distribuidor')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExist('distribuidor_demanda_distribuidor');
    }
}
