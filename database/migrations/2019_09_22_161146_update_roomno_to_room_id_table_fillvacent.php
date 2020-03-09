<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRoomnoToRoomIdTableFillvacent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fillvacents', function (Blueprint $table) {
            $table->dropColumn('room_no');
            $table->integer('room_id')->after('student_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fillvacents', function (Blueprint $table) {
            $table->dropColumn('room_id');
            $table->integer('room_no')->after('student_id');
        });
    }
}
