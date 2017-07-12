<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditoTable extends Migration
{
    public function up()
    {
        Schema::create('credito', function (Blueprint $table){
        	$table->increments('id');
        	$table->string('plan');
        	$table->integer('cantidad_creditos');
        	$table->double('precio', 6, 2);
        	$table->text('descripcion');
          	$table->timestamps();
        });

        Schema::create('productor_credito', function (Blueprint $table){
            $table->increments('id');
            $table->integer('credito_id');
            $table->integer('productor_id');
            $table->double('total', 6, 2);
            $table->date('fecha_compra');
            $table->timestamps();

            $table->foreign('credito_id')
                  ->references('id')->on('credito')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('productor_id')
                  ->references('id')->on('productor')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        Schema::create('importador_credito', function (Blueprint $table){
            $table->increments('id');
            $table->integer('credito_id');
            $table->integer('importador_id');
            $table->double('total', 6, 2);
            $table->date('fecha_compra');
            $table->timestamps();

            $table->foreign('credito_id')
                  ->references('id')->on('credito')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('importador_id')
                  ->references('id')->on('importador')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        Schema::create('distribuidor_credito', function (Blueprint $table){
            $table->increments('id');
            $table->integer('credito_id');
            $table->integer('distribuidor_id');
            $table->double('total', 6, 2);
            $table->date('fecha_compra');
            $table->timestamps();

            $table->foreign('credito_id')
                  ->references('id')->on('credito')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('distribuidor_id')
                  ->references('id')->on('distribuidor')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

         Schema::create('horeca_credito', function (Blueprint $table){
            $table->increments('id');
            $table->integer('credito_id');
            $table->integer('horeca_id');
            $table->double('total', 6, 2);
            $table->date('fecha_compra');
            $table->timestamps();

            $table->foreign('credito_id')
                  ->references('id')->on('credito')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('horeca_id')
                  ->references('id')->on('horeca')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('credito');
        Schema::dropIfExists('productor_credito');
        Schema::dropIfExists('importador_credito');
        Schema::dropIfExists('distribuidor_credito');
        Schema::dropIfExists('horeca_credito');
    }
}
