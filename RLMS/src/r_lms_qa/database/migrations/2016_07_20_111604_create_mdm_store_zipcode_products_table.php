<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMdmStoreZipcodeProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mdm_store_zipcode_products', function (Blueprint $table) {
            $table->increments('szp_id');
			$table->string('szp_store',50);
			$table->string('szp_zipcodes',50);
			$table->string('szp_kitchen',50);
			$table->string('szp_bath',50);
			$table->string('szp_garage',50);
			$table->string('szp_closet',50);
			$table->string('szp_kitchen_remodeling',50);
			$table->string('szp_bath_remodeling',50);
			$table->string('szp_backsplash',50);
			$table->string('szp_countertop',50);
			$table->string('szp_active',3);
			$table->string('szp_created_by',50);
			$table->string('szp_created_datetime',250);
			$table->string('szp_updated_by',50);
			$table->string('szp_updated_datetime',250);
			$table->string('szp_deleted_by',50);
			$table->string('szp_deleted_datetime',250);
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
        Schema::drop('mdm_store_zipcode_products');
    }
}
