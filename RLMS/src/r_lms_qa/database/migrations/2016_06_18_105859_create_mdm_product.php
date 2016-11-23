<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMdmProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::create('mdm_remap_product', function (Blueprint $table) {
		
		
			$table->increments('mrp_Id');
					$table->integer('mrp_CompanyId')->nullable();
					$table->string('mrp_Hdiproduct',100)->nullable();
					$table->string('mrp_Hdeproduct',100)->nullable();
					$table->string('mrp_Active',10)->nullable();
					$table->timestamp('mrp_CreatedDate')->nullable();
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
