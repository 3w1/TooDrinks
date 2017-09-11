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
    }

    public function down()
    {
        Schema::dropIfExists('suscripcion');
        Schema::dropIfExists('productor_suscripcion');
        Schema::dropIfExists('importador_suscripcion');
        Schema::dropIfExists('distribuidor_suscripcion');
    }
}
