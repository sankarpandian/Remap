<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsSlotchangelogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_slotchangelogs', function (Blueprint $table) {
            $table->increments('lscl_ChangeLogId');
			$table->string('lscl_ChangeBy',100);
			$table->integer('lscl_TerritoryId');
			$table->integer('lscl_SlotId');
			$table->integer('lscl_ModifiedDate');
			$table->string('lscl_Status',20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lms_slotchangelogs');
    }
}
