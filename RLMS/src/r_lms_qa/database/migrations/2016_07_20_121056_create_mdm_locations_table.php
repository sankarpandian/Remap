<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMdmLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mdm_locations', function (Blueprint $table) {
            $table->increments('location_id');
			$table->string('location_name',25);
			$table->string('location_territory',2);
			$table->integer('branch_id');
			$table->string('time_zone',10);
			$table->string('last_modified_date',10);
			$table->string('delete_flag',2);
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
        Schema::drop('mdm_locations');
    }
}
