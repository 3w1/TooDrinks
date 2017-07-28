<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeduccionCreditoMultinacionalTable extends Migration
{
    public function up()
    {
         Schema::create('deduccion_credito_multinacional', function (Blueprint $table){
            $table->increments('id');
            $table->integer('multinacional_id');
            $table->date('fecha');
            $table->text('descripcion');
            $table->integer('cantidad_creditos');
            $table->string('tipo_deduccion');
            $table->integer('accion_id');
            $table->timestamps();

            $table->foreign('multinacional_id')
                  ->references('id')->on('multinacional')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('deduccion_credito_multinacional');
    }
}
