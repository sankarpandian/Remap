<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemapCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remap_companies', function (Blueprint $table) {
            $table->increments('id');
			$table->string('remp_company_name');
			$table->mediumText('remp_url');
			$table->char('remp_auth_flag',1);
			$table->char('remp_active_status',1);
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
        Schema::drop('remap_companies');
    }
}
