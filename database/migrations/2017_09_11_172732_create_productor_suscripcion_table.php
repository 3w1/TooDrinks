<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductorSuscripcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productor_suscripcion', function (Blueprint $table){
            $table->increments('id');
            $table->integer('suscripcion_id');
            $table->integer('productor_id');
            $table->double('pago', 6, 2);
            $table->date('fecha_compra');
            $table->timestamps();

            $table->foreign('suscripcion_id')
                  ->references('id')->on('suscripcion')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('productor_id')
                  ->references('id')->on('productor')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        Schema::create('importador_suscripcion', function (Blueprint $table){
            $table->increments('id');
            $table->integer('suscripcion_id');
            $table->integer('importador_id');
            $table->double('pago', 6, 2);
            $table->date('fecha_compra');
            $table->timestamps();

            $table->foreign('suscripcion_id')
                  ->references('id')->on('suscripcion')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('importador_id')
                  ->references('id')->on('importador')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        Schema::create('distribuidor_suscripcion', function (Blueprint $table){
            $table->increments('id');
            $table->integer('suscripcion_id');
            $table->integer('distribuidor_id');
            $table->double('pago', 6, 2);
            $table->date('fecha_compra');
            $table->timestamps();

            $table->foreign('suscripcion_id')
                  ->references('id')->on('suscripcion')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('distribuidor_id')
                  ->references('id')->on('distribuidor')
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
