<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsSlotchangelogdatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_slotchangelogdatas', function (Blueprint $table) {
            $table->increments('lscld_ChangeLogDataId');
			$table->integer('lscld_SlotId');
			$table->integer('lscld_DateMasterId');
			$table->integer('lscld_TimeMasterId');
			$table->integer('lscld_ModifiedData');
			$table->integer('lscld_ChangeLogId');
			$table->string('lscld_Status',10);
			
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lms_slotchangelogdatas');
    }
}
