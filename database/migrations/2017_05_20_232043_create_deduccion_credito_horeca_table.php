<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeduccionCreditoHorecaTable extends Migration
{
    public function up()
    {
        Schema::create('deduccion_credito_horeca', function (Blueprint $table){
            $table->increments('id');
            $table->integer('horeca_id');
            $table->date('fecha');
            $table->text('descripcion');
            $table->integer('cantidad_creditos');
            $table->string('tipo_deduccion');
            $table->integer('accion_id');
            $table->timestamps();

            $table->foreign('horeca_id')
                  ->references('id')->on('horeca')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('deduccion_credito_horeca');
    }
}
