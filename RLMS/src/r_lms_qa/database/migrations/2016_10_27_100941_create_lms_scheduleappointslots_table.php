<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsScheduleappointslotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_scheduleappointslots', function (Blueprint $table) {
            $table->increments('lsa_ScheduleAppointId');
			$table->integer('lsa_RequestId');
			$table->integer('lsa_SlotId');
			$table->integer('lsa_DateMasterId');
			$table->integer('lsa_TimeMasterId');
			$table->string('lsa_TimeZone',10);
			$table->string('lsa_LoackStatus',25);
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
        Schema::drop('lms_scheduleappointslots');
    }
}
