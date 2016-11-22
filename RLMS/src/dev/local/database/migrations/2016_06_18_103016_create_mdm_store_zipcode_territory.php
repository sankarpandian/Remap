<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMdmStoreZipcodeTerritory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		
		Schema::create('mdm_store_zipcode_territory', function (Blueprint $table) {
		
					$table->increments('mszt_Id');
					$table->integer('mszt_CompanyId')->nullable();
					$table->string('mszt_Store',5)->nullable();
					$table->string('mszt_Kitchen',100)->nullable();
					$table->string('mszt_Bath',100)->nullable();
					$table->string('mszt_Garage',100)->nullable();
					$table->string('mszt_Closet',100)->nullable();
					$table->string('mszt_KitchenRemodeling',100)->nullable();
					$table->string('mszt_BathRemodeling',100)->nullable();
					$table->string('mszt_Backsplash',100)->nullable();
					$table->string('mszt_Countertop',100)->nullable();
					$table->string('mszt_Active',10)->nullable();
					$table->string('mszt_CreatedBy',100)->nullable();
					$table->timestamp('mszt_CreatedDatetime')->nullable();
					$table->string('mszt_UpdatedBy',100)->nullable();	
					$table->timestamp('mszt_UpdatedDatetime')->nullable();
					$table->string('mszt_DeletedBy',100)->nullable();	
					$table->timestamp('mszt_DeletedDatetime')->nullable();
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
