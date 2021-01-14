<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNominationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nominations', function (Blueprint $table) {
            $table->id(); 
            $table->date('date_awarded'); 
            $table->unsignedBigInteger('award_id'); 
            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')->references('id')->on('members')->onCascade('delete');
            $table->foreign('award_id')->references('id')->on('nomination_awards')->onCascade('delete');
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
        Schema::dropIfExists('nominations');
    }
}
