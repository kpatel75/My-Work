<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id('id')->autoincrement();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('preferred_name')->nullable();
            $table->string('address');
            $table->string('email');
            $table->string('home_phone')->nullable();
            $table->string('work_phone')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('country');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->date('birthdate');
            $table->string('province');
            $table->string('city');
            $table->string('postal_code');
            $table->bigInteger('jurisdiction_id')->unsigned();
            $table->foreign('jurisdiction_id')->references('id')->on('jurisdictions');
            $table->bigInteger('chapter_id')->unsigned(); 
            //$table->foreign('chapter_id')->references('id')->on('chapters');
            $table->foreign(['chapter_id', 'jurisdiction_id'])->references(['id', 'jurisdiction_id'])->on('chapters');
            $table->date('initiatory_date')->nullable();
            $table->date('senior_demolay_date')->nullable();
            $table->date('demolay_degree_date')->nullable();
            $table->boolean('father_senior_status')->default(false);
            $table->boolean('father_mason_status')->default(false);
            $table->string('father_senior_location')->nullable();
            $table->string('father_mason_location')->nullable();
            $table->string('mother_mason_other')->nullable();
            $table->string('guardian_one_name')->nullable();
            $table->string('guardian_one_senior_status')->default(false);
            $table->string('guardian_one_mason_status')->default(false);
            $table->string('guardian_one_senior_location')->nullable();
            $table->string('guardian_one_mason_location')->nullable();
            $table->string('guardian_one_mason_other')->nullable();
            $table->string('guardian_two_name')->nullable();
            $table->string('guardian_two_senior_status')->default(false);
            $table->string('guardian_two_mason_status')->default(false);
            $table->string('guardian_two_senior_location')->nullable();
            $table->string('guardian_two_mason_location')->nullable();
            $table->string('guardian_two_mason_other')->nullable();
            $table->bigInteger('sponsor_id');
            $table->string('sponsor_name');
            $table->datetime('updated_at');
            $table->datetime('created_at');
            $table->string('status')->default('Applicant');
            $table->bigInteger('position_id')->unsigned()->default(1);
            $table->foreign('position_id')->references('id')->on('positions');
            $table->string('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
