<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapters', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned();
            $table->bigInteger('jurisdiction_id')->unsigned(); 
            $table->string('description'); 
            $table->string('location');
            $table->primary(array('id', 'jurisdiction_id'));
            $table->foreign('jurisdiction_id')->references('id')->on('jurisdictions')->onCascade('delete');
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
        Schema::dropIfExists('chapters');
    }
}
