<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeTypeFloatOfMealNoTableMonthlyCalculations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monthly_calculations', function (Blueprint $table) {
            $table->float('meal_no', 4, 1)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monthly_calculations', function (Blueprint $table) {
            $table->integer('meal_no')->change();
        });
    }
}
