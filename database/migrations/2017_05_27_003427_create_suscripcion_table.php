<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuscripcionTable extends Migration
{
    public function up()
    {
        Schema::create('suscripcion', function (Blueprint $table){
            $table->increments('id');
            $table->string('suscripcion');
            $table->text('descripcion');
            $table->double('precio', 6, 2);
            $table->timestamps();
        });

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

    public function down()
    {
        Schema::dropIfExists('suscripcion');
        Schema::dropIfExists('productor_suscripcion');
        Schema::dropIfExists('importador_suscripcion');
        Schema::dropIfExists('distribuidor_suscripcion');
    }
}
