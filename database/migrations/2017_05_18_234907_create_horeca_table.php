<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorecaTable extends Migration
{
   public function up(){
      Schema::create('horeca', function (Blueprint $table){
         $table->increments('id');
         $table->integer('user_id');
         $table->string('nombre');
         $table->string('nombre_seo')->nullable();
         $table->text('descripcion')->nullable();
         $table->text('direccion')->nullable();
         $table->integer('codigo_postal')->nullable();
         $table->integer('pais_id');
         $table->integer('provincia_region_id');
         $table->string('logo')->nullable();
         $table->string('persona_contacto')->nullable();
         $table->string('telefono')->nullable();
         $table->string('telefono_opcional')->nullable(); 
         $table->string('email')->unique();
         $table->string('website')->nullable();
         $table->string('facebook')->nullable();
         $table->string('twitter')->nullable();
         $table->string('instagram')->nullable();
         $table->boolean('reclamada');
         $table->double('latitud', 10, 8)->nullable();
         $table->double('longitud', 10, 8)->nullable();
         $table->boolean('estado_datos');
         $table->enum('tipo_horeca', ['H', 'R', 'C']);
         $table->integer('saldo');
         $table->boolean('invitacion');
         $table->date('fecha_invitacion')->nullable();
         $table->timestamps();

         $table->foreign('user_id')
      		  ->references('id')->on('users')
   			  ->onDelete('restrict')
   			  ->onUpdate('cascade');
            
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
        Schema::dropIfExists('horeca');
    }
}
