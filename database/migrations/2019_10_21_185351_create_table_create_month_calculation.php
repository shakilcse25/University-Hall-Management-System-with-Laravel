<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCreateMonthCalculation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('createmonth_calculations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('month');
            $table->string('elec_bill')->nullable();
            $table->string('internet_bill')->nullable();
            $table->integer('meal_rate')->nullable()->default(0);
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
        Schema::dropIfExists('createmonth_calculations');
    }
}
