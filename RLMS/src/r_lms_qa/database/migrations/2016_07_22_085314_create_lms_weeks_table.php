<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsWeeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_weeks', function (Blueprint $table) {
            $table->bigIncrements('week_id');
            $table->integer('company_id');
			$table->date('week_start_date');
			$table->date('week_end_date');
			$table->string('week_display',50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lms_weeks');
    }
}
