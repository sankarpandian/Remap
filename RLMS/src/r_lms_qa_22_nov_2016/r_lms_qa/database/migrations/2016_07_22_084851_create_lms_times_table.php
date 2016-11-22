<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_times', function (Blueprint $table) {
            $table->increments('time_id');
			$table->string('time_master',20);
			$table->string('calen_product',20);
			$table->integer('oldr_sent_status');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lms_times');
    }
}
