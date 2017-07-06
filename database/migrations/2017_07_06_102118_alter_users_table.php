<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{

    public function up()
    {
        Schema::table('users', function (Blueprint $table){
            $table->enum('rol', ['AD', 'MB', 'SA'])->nullable();
        });
    }


    public function down()
    {

    }
}
