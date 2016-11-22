<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('lms_slots', function (Blueprint $table) {
            $table->bigIncrements('lmss_slot_id');
            $table->integer('lmss_company_id');
			$table->bigInteger('lmss_week_id');
			$table->Integer('lmss_week_reps');
			$table->Integer('lmss_total_reps');
			$table->string('lmss_slot_comments');
			$table->date('lmss_slot_projected_date');
			$table->bigInteger('lmss_slot_status_id');
			$table->Integer('lmss_pending_review');
			$table->datetime('lmss_created_date');
			$table->datetime('lmss_updated_date');
			$table->Integer('lmss_territory_id');
			$table->string('lmss_calen_product',20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lms_slots');
    }
}
