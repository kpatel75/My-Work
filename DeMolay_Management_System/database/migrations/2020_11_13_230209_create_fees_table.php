<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('jurisdiction_id');
            $table->unsignedBigInteger('chapter_id');
            $table->unique(array('id', 'jurisdiction_id', 'chapter_id'));
            $table->double('amount');
            $table->unsignedBigInteger('description_id');
            $table->double('demolay_contribution')->default(0);
            $table->double('chapter_contribution')->defualt(0);
            $table->unsignedBigInteger('added_by');
            $table->unsignedBigInteger('edited_by_id')->nullable();
            $table->string('edited_by_first_name')->nullable();
            $table->string('edited_by_last_name')->nullable();
            $table->year('year');
            $table->timestamps();

            $table->foreign('jurisdiction_id')->references('id')->on('jurisdictions')->onDelete('cascade');
            $table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('cascade');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('edited_by_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('description_id')->references('id')->on('fee_descriptions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fees');
    }
}
