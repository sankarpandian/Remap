<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_calendars', function (Blueprint $table) {
            $table->increments('calendar_id');
			$table->integer('company_id');
			$table->string('calendar_name',50);
			$table->dateTime('created_date');
			$table->dateTime('modified_date');
			
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lms_calendars');
    }
}
