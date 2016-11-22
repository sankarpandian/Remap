<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMdmCityState extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		
		Schema::create('mdm_remap_city_state', function (Blueprint $table) {
		
		
				$table->increments('mrcs_Id');
				$table->integer('mrcs_CompanyId')->nullable();	
				$table->string('mrcs_Zipcode',5)->nullable();	   
				$table->string('mrcs_City',75)->nullable();
				$table->string('mrcs_State',5)->nullable();
				$table->string('mrcs_County',75)->nullable();	
				$table->integer('mrcs_StoreId')->nullable();		 	 	
				$table->string('mrcs_StoreName',50)->nullable();	
				$table->integer('mrcs_MarketId')->nullable();	
				$table->string('mrcs_MarketName',75)->nullable();	
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
