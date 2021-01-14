<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('fee_id');
            $table->double('amount_paid')->nullable()->defualt(0);
            $table->double('amount_outstanding')->nullable();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('advisor_id');
            $table->string('special_case')->default('None');
            $table->unsignedBigInteger('sponsor_id')->nullable();
            $table->string('sponsor_first_name')->nullable();
            $table->string('sponsor_last_name')->nullable();
            $table->date('payment_date');
            $table->timestamps();

            $table->foreign('fee_id')->references('id')->on('fees')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('advisor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sponsor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
