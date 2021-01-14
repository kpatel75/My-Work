<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { Schema::create('roles', function (Blueprint $table) {
    
        $table->id();
        $table->string('role_name'); 
        $table->bigInteger('role_access')->unsigned();  
        $table->bigInteger('role_permissions_id')->unsigned()->nullable();
        $table->timestamps();  
        $table->foreign('role_access')->references('id')->on('access_roles')->onCascade('delete');  
        $table->foreign('role_permissions_id')->references('id')->on('role_permissions')->onCascade('delete');  

    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
