<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_branches', function (Blueprint $table) {
           $table->increments('lmsb_territory_id');
			$table->string('lmsb_territory_name',110);
			$table->string('lmsb_territory_code',25);
			$table->Integer('lmsb_company_id');
			$table->Integer('lmsb_branch_id');
			$table->string('lmsb_company',100);
			$table->string('lmsb_sales_mgr',100);
			$table->string('lmsb_sales_email',200);
			$table->string('lmsb_sales_mgr_adid',100);
			$table->string('lmsb_hot_hash1',100);
			$table->string('lmsb_hot_hash1_email',200);
			$table->string('lmsb_hot_hash1_adid',100);
			$table->string('lmsb_hot_hash2',100);
			$table->string('lmsb_hot_hash2_email',200);
			$table->string('lmsb_hot_hash2_adid',200);
			$table->string('lmsb_address',255);
			$table->string('lmsb_phone',15);
			$table->string('lmsb_fax',15);
			$table->string('lmsb_branch',75);
			$table->string('lmsb_category',10);
			$table->string('lmsb_region',25);
			$table->string('lmsb_time_zone',25);
			$table->string('lmsb_vendor',25);
			$table->string('lmsb_delete_flag',2);
			$table->string('lmsb_product',20);
			$table->timestamp('lmsb_last_modified_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lms_branches');
    }
}
