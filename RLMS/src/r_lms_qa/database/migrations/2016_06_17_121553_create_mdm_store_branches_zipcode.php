<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMdmStoreBranchesZipcode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		
			Schema::create('mdm_store_branches_zipcode', function (Blueprint $table) {
            
			$table->increments('mszr_Id');
			$table->integer('mszr_CompanyId')->nullable();
            $table->string('mszr_Store',5)->nullable();
			$table->integer('mszr_BranchId')->nullable();
			$table->string('mszr_Zipcodes',10)->nullable();
			$table->string('mszr_Active',5)->nullable();
			$table->string('mszr_CreatedBy',50)->nullable();
			$table->timestamp('mszr_CreatedDatetime')->nullable();
			$table->string('mszr_UpdatedBy',50)->nullable();
			$table->timestamp('mszr_UpdatedDatetime')->nullable();
			$table->string('mszr_DeletedBy',50)->nullable();
			$table->timestamp('mszr_DeletedDatetime')->nullable();
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
        //
    }
}
