<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEggMealCostToMealStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meal_students', function (Blueprint $table) {
            $table->boolean('egg')->after('room_no')->default(0);
            $table->float('meal_cost',10,4)->after('room_no')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meal_students', function (Blueprint $table) {
            $table->dropColumn('egg');
            $table->dropColumn('meal_cost');
        });
    }
}
