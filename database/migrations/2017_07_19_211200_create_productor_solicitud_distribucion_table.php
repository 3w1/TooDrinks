<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductorSolicitudDistribucionTable extends Migration
{

    public function up()
    {
        Schema::create('productor_solicitud_distribucion', function (Blueprint $table){
            $table->increments('id');
            $table->integer('productor_id');
            $table->integer('solicitud_distribucion_id');
            $table->date('fecha');
            $table->timestamps();

            $table->foreign('productor_id')
                  ->references('id')->on('productor')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('solicitud_distribucion_id')
                  ->references('id')->on('solicitud_distribucion')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
