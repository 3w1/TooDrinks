<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('producto', function(Blueprint $table){
            $table->enum('tipo_creador', ['U', 'P', 'I', 'D']);
            $table->integer('creador_id');
            $table->boolean('publicado')->default(1);
            $table->boolean('confirmado')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumn('tipo_creador');
        Schema::dropColumn('creador_id');
        Schema::dropColumn('publicado');
        Schema::dropColumn('confirmado');
    }
}
