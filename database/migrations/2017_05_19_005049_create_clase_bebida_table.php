<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClaseBebidaTable extends Migration
{
    public function up()
    {
        Schema::create('clase_bebida', function (Blueprint $table){
            $table->increments('id');
            $table->integer('bebida_id');
            $table->string('clase');
            $table->text('caracteristicas');
            $table->timestamps();

            $table->foreign('bebida_id')
      			  ->references('id')->on('bebida')
      			  ->onDelete('restrict')
      			  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('clase_bebida');
    }
}
