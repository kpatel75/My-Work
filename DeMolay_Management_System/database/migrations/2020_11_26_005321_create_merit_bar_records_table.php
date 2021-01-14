<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeritBarRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merit_bar_records', function (Blueprint $table) {
           // $table->id(); 
            $table->bigInteger('member_id')->unsigned(); 
            $table->bigInteger('activity_id')->unsigned();
            $table->bigInteger('merit_bar_id')->unsigned(); 
            $table->date('date_achieved');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->primary(array('member_id', 'activity_id', 'merit_bar_id'));
            $table->foreign('activity_id')->references('id')->on('activity_categories')->onDelete('cascade'); 
            $table->foreign('merit_bar_id')->references('id')->on('merit_bars')->onDelete('cascade');
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
        Schema::dropIfExists('merit_bar_records');
    }
}
