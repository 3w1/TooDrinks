<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCosteCreditoTable extends Migration
{

    public function up()
    {
        Schema::create('coste_credito', function (Blueprint $table){
            $table->increments('id');
            $table->text('accion');
            $table->text('entidad');
            $table->integer('cantidad_creditos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('coste_credito');
    }
}
