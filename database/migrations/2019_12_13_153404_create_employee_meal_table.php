<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeMealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_meals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('meal_id');
            $table->bigInteger('employee_id');
            $table->integer('meal_cost');
            $table->integer('meal_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_meal');
    }
}
