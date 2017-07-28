<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMultinacionalCreditoTable extends Migration
{
    public function up()
    {
        Schema::create('multinacional_credito', function (Blueprint $table){
            $table->increments('id');
            $table->integer('credito_id');
            $table->integer('multinacional_id');
            $table->double('total', 6, 2);
            $table->date('fecha_compra');
            $table->timestamps();

            $table->foreign('credito_id')
                  ->references('id')->on('credito')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('multinacional_id')
                  ->references('id')->on('multinacional')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('multinacional_credito');
    }
}
