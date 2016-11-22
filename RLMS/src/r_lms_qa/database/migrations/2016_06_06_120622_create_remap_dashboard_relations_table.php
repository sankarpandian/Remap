<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemapDashboardRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remap_dashboard_relations', function (Blueprint $table) {
            $table->increments('id');
			$table->string('relat_user_id');
			$table->integer('relat_section_id');
			$table->integer('relat_menu_id');
			$table->integer('relat_sub_menu_id');
			$table->char('relat_status',1);
			$table->string('relat_created_by');
			$table->string('relat_updated_by');
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
        Schema::drop('remap_dashboard_relations');
    }
}
