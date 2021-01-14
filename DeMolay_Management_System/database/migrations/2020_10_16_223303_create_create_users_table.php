<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('create_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('create_access_role_id'); 
            $table->unSignedBigInteger('user_access_role_id');
            $table->timestamps(); 

            $table->foreign('create_access_role_id')->references('id')->on('roles')->onCascade('delete'); 
            $table->foreign('user_access_role_id')->references('id')->on('roles')->onCascade('delete'); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('create_users');
    }
}
