<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemapUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remap_users', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('usrs_company_id');
			$table->string('usrs_firstname');
			$table->string('usrs_lastname');
			$table->string('usrs_email');
			$table->string('usrs_username');
			$table->string('usrs_password');
			$table->string('usrs_userid');
			$table->string('usrs_status');
			$table->string('usrs_created_date');
			$table->string('usrs_updated_date');
            $table->timestamps();
			$table->string('usrs_role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('remap_users');
    }
}
