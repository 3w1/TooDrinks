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
            $table->integer('id_creador');
            $table->boolean('publicada')->default(1);
            $table->boolean('confirmada')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
