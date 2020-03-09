<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMonthlyCalulation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_calculations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('month_id');
            $table->string('std_id');
            $table->integer('room_no');
            $table->integer('deposit');
            $table->integer('elec_bill')->nullable();
            $table->integer('internet_bill')->nullable();
            $table->integer('seat_bill');
            $table->integer('meal_no')->default(0);
            $table->integer('meal_cost');
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
        Schema::dropIfExists('monthly_calculations');
    }
}
