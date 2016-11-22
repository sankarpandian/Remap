<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsSlotRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_slot_relations', function (Blueprint $table) {
            $table->bigIncrements('lmssr_slot_relation_id');
            $table->integer('lmssr_company_id');
			$table->bigInteger('lmssr_slot_id');
			$table->bigInteger('lmssr_date_master_id');
			$table->bigInteger('lmssr_time_master_id');
			$table->integer('lmssr_old_manager_request');
			$table->integer('lmssr_manager_request');
			$table->integer('lmssr_recommended');
			$table->integer('lmssr_previous');
			$table->integer('lmssr_actual');
			$table->integer('lmssr_allocated');
			$table->integer('lmssr_confirmation_actual');
			$table->integer('lmssr_confirmation_allocated');
			$table->integer('lmssr_sched_manual');
			$table->integer('lmssr_conf_manual');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lms_slot_relations');
    }
}
