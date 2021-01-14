<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); 
            $table->unsignedBigInteger('jurisdiction_id')->nullable()->constrained();
            $table->unsignedBigInteger('chapter_id')->nullable()->constrained()->default(null); 
            $table->unsignedBigInteger('member_id')->nullable()->constrained()->default(null);
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('jurisdiction_id')->references('id')->on('jurisdictions')->onCascade('delete');
            //$table->foreign(['chapter_id', 'jurisdiction_id'])->references(['id', 'jurisdiction_id'])->on('chapters')->onCascade('delete')->onUpdate('cascade');
            //$table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('SET NULL')->onUpdate('SET NULL');
            $table->foreign('member_id')->references('id')->on('members')->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
