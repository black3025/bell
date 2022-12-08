<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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

            $table->integer('loan_id')->unsigned();
            $table->foreign('loan_id')->references('id')->on('loans');

            $table->double('amount');
            $table->string('or_number')->nullable();
            $table->integer('p_nlid')->unsigned();
            $table->string('date');

            $table->integer('user_id')->unsigned(); //who_posted
            $table->foreign('user_id')->references('id')->on('users');
            
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
        Schema::dropIfExists('payments');
    }
};
