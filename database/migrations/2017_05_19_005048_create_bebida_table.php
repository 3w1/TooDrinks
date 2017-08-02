<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBebidaTable extends Migration
{
    public function up()
    {
        Schema::create('bebida', function (Blueprint $table){
            $table->increments('id');
            $table->string('nombre');
            $table->longText('caracteristicas')->nullable();
            $table->string('imagen')->nullable();
            $table->timestamps();

            $table->foreign('pais_id')
                  ->references('id')->on('pais')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bebida');
    }
}
