<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsCallStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_call_status', function (Blueprint $table) {
            $table->increments('lmscs_call_status_id');
			$table->string('lmscs_call_status',50);
			$table->integer('lmscs_call_from');
			$table->string('report_name',50);
			$table->enum('lmscs_statustype', array('final', 'nonfinal'));
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lms_call_status');
    }
}
