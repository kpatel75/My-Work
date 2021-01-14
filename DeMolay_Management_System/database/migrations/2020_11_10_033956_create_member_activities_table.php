<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_activities', function (Blueprint $table) {
            $table->id('activityid')->autoincrement();
            $table->unsignedBigInteger('memberid');
            $table->unsignedBigInteger('advisorid');
            $table->unsignedBigInteger('type_of_activityid');
            $table->string('note')->nullable();
            $table->date('date');
            $table->integer('no_of_hour')->nullable();
            $table->integer('point')->nullable();
            $table->integer('mile')->nullable();
            $table->timestamps();

            $table->foreign('memberid')->references('id')->on('members')->onCascade('delete');
            $table->foreign('advisorid')->references('id')->on('users')->onCascade('delete');
            $table->foreign('type_of_activityid')->references('id')->on('activity_categories')->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_activities');
    }
}
