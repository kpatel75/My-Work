<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_descriptions', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('jurisdiction_id');
            $table->unsignedBigInteger('chapter_id');
            $table->unique(array('id', 'jurisdiction_id', 'chapter_id'));
            $table->string('description');
            $table->timestamps();

            $table->foreign('jurisdiction_id')->references('id')->on('jurisdictions')->onDelete('cascade');
            $table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_descriptions');
    }
}
