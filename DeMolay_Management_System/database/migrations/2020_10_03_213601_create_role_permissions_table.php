<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id(); 
            $table->boolean('member_read'); 
            $table->boolean('member_write');
            $table->boolean('jurisdiction_read');
            $table->boolean('jurisdiction_write');
            $table->boolean('country_read');
            $table->boolean('country_write'); 
           // $table->bigInteger('role_id')->unsigned(); 
           // $table->foreign('role_id')->references('id')->on('roles')->onCascade('delete');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_permissions');
    }
}
