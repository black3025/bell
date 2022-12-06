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
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->string('rel_date');
            $table->string('beg_date');
            $table->string('end_date');
            $table->double('principle_amount');
            $table->double('balance');
            $table->tinyInteger('cycle');
            $table->string('close_date')->nullable();
            //new columns
            $table->tinyInteger('is_active');
            $table->string('category');
            $table->tinyInteger('approvals');
            $table->string('approval_date')->nullable();
            $table->string('approval_notes')->nullable();
            //pasiguro
            $table->string('acctname')->nullable();
            $table->string('area')->nullable();

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
        Schema::dropIfExists('loans');
    }
};
