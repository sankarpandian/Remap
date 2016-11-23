<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsScreensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_screens', function (Blueprint $table) {
            $table->increments('lsn_ScreentId');
			$table->integer('lsn_CompanyId');
			$table->integer('lsn_BucketId');
			$table->string('lsn_ScreenName');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lms_screens');
    }
}
