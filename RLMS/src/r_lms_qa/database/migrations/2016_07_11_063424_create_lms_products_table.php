<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_products', function (Blueprint $table) {
            $table->increments('id');
			$table->string('product_code');
			$table->string('product_name');
			$table->string('siebel_product');
			$table->string('product_isactive');
			
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
        Schema::drop('lms_products');
    }
}
