<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsBucketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_buckets', function (Blueprint $table) {
            $table->increments('lb_BucketId');
			$table->integer('lb_CompanyId');
			$table->string('lb_BucketName');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lms_buckets');
    }
}
