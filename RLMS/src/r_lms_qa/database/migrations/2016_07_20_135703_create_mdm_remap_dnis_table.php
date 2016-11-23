<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMdmRemapDnisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mdm_remap_dnis', function (Blueprint $table) {
            $table->increments('mdnis_DnisId');
			$table->integer('mdnis_CompanyId');
			$table->string('mdnis_Dnis',25);
			$table->string('mdnis_ProspectId',55);
			$table->integer('mdnis_SiebelLeadsourcetyPecode');
			$table->string('mdnis_CompanyCode',20);
			$table->string('mdnis_ProductCode',20);
			$table->string('mdnis_Source',100);
			$table->string('mdnis_Description',255);
			$table->string('mdnis_AdvertisingCode',10);
			$table->string('mdnis_Category',20);
			$table->integer('mdnis_CategoryId');
			$table->string('mdnis_ShowLms',255);
			$table->string('mdnis_LastModifiedDate',255);
			$table->string('mdnis_CreatedBy',255);
			$table->string('mdnis_CreatedDatetime',255);
			$table->string('mdnis_ModifiedBy',50);
			$table->string('mdnis_ModifiedDatetime',255);
			$table->string('mdnis_DeletedBy',50);
			$table->string('mdnis_DeletedDatetime',255);
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
        Schema::drop('mdm_remap_dnis');
    }
}
