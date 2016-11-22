<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsTimeMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_time_masters', function (Blueprint $table) {
            $table->bigIncrements('time_master_id');
			$table->integer('company_id');
			$table->bigInteger('date_master_id');
			$table->bigInteger('time_id');
			$table->string('active',2);
            $table->string('calen_product',20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lms_time_masters');
    }
}
