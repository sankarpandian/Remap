<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsCalldetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_calldetails', function (Blueprint $table) {
            $table->increments('lld_CallId');
            $table->integer('lld_CustomerId');
            $table->integer('lld_CallFromId');
            $table->string('lld_ProsepctId',25);
            $table->string('lld_ProductCode',3);
            $table->integer('lld_SlotId');
            $table->integer('lld_CallbackId');
            $table->string('lld_VerificationCode',25);
            $table->string('lld_StoreId',25);
            $table->string('lld_AssociateId',25);
            $table->integer('lld_CallStatusId');
            $table->integer('lld_NonProductId');
            $table->integer('lld_AgentCreatedBy');
            $table->integer('lld_AgentUpdatedBy');
            $table->integer('lld_AssignedBy');
            $table->integer('lld_ResultedBy');
            $table->integer('lld_CallTypeId');
            $table->integer('lld_OriginSourceId');
            $table->string('lld_LiveStatus',25);
            $table->integer('lld_LeadBucketID');
            $table->integer('lld_RepAssigned');
            $table->integer('lld_RepResulted');
            $table->integer('lld_PriorityOrder');
            $table->dateTime('lld_PrioritySetDate');           
            $table->string('lld_PrioritySetBy',50);
			$table->integer('lld_FinishCallButton');
			$table->dateTime('lld_CallDateTime');
			$table->dateTime('lld_RecordCreatedDateTime');
			$table->dateTime('lld_RescheduleCreatedDateTime');
			$table->dateTime('lld_LastModifiedDate');			
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
        Schema::drop('lms_calldetails');
    }
}
