<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsCalendarTerritoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_calendar_territories', function (Blueprint $table) {
            $table->increments('lmsct_id');
			$table->integer('lmsct_company_id');
			$table->integer('lmsct_calendar_id');
			$table->integer('lmsct_territory_id');
			$table->string('lmsct_open_status',10);
			$table->string('lmsct_active_status',2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lms_calendar_territories');
    }
}
