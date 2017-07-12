<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('rol', ['AD', 'US', 'MB', 'SA']);
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nombre');
            $table->string('apellido');
            $table->text('direccion');
            $table->string('telefono');
            $table->string('telefono_opcional')->nullable();   
            $table->integer('codigo_postal');
            $table->integer('pais_id');
            $table->integer('provincia_region_id');
            $table->string('avatar');
            $table->boolean('estado_datos'); 
            $table->boolean('productor'); 
            $table->boolean('importador'); 
            $table->boolean('distribuidor'); 
            $table->boolean('horeca'); 
            $table->boolean('multinacional');
            $table->boolean('activado');
            $table->integer('cantidad_entidades');
            $table->string('codigo_confirmacion')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('pais_id')
      			  ->references('id')->on('pais')
      			  ->onDelete('restrict')
      			  ->onUpdate('cascade');

      		 $table->foreign('provincia_region_id')
      			  ->references('id')->on('provincia_region')
      			  ->onDelete('restrict')
      			  ->onUpdate('cascade');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
