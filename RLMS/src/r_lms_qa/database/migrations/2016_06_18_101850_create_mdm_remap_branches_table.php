<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMdmRemapBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		
		Schema::create('mdm_remap_branches', function (Blueprint $table) {
 			 $table->increments('mrb_Id');
			 $table->integer('mrb_CompanyId')->nullable();
			$table->integer('mrb_BranchId')->nullable();
			$table->string('mrb_CompanyName',100)->nullable();
			$table->text('mrb_Address')->nullable();
			$table->string('mrb_Phone',15)->nullable();
			$table->string('mrb_Fax',15)->nullable();
			$table->string('mrb_Branch',100)->nullable();
			$table->string('mrb_BranchCode',15)->nullable();
			$table->string('mrb_Category',15)->nullable();  
			$table->string('mrb_Region',50)->nullable();
			$table->string('mrb_Rendor',50)->nullable(); 	
			$table->integer('mrb_TerritoryCode')->nullable();
			$table->string('mrb_DeleteFlag',100)->nullable();
			$table->timestamp('mrb_LastModifiedDate')->nullable();
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
