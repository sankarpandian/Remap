<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsCustomerslotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_customerslots', function (Blueprint $table) {
            $table->increments('lcs_SlotId');
            $table->integer('lcs_CustomerId');
            $table->string('lcs_LeadCaption',3);
            $table->string('lcs_LeadID',25);
            $table->bigInteger('lcs_WeekSlotId');
            $table->bigInteger('lcs_DateMasterId');
            $table->bigInteger('lcs_TimeMasterId');
            $table->dateTime('lcs_ApptDateTime');
            $table->dateTime('lcs_CreatedDate');
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
        Schema::drop('lms_customerslots');
    }
}
