<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaisTable extends Migration
{
    public function up()
    {
        Schema::create('pais', function (Blueprint $table ){
            $table->increments('id');
            $table->string('pais');
            $table->timestamps();
        });

        Schema::create('provincia_region', function (Blueprint $table ){
            $table->increments('id');
            $table->string('provincia');
            $table->integer('pais_id');
            $table->timestamps();

            $table->foreign('pais_id')
      			  ->references('id')->on('pais')
      			  ->onDelete('restrict')
      			  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pais');
        Schema::dropIfExists('provincia_region');
    }
}
