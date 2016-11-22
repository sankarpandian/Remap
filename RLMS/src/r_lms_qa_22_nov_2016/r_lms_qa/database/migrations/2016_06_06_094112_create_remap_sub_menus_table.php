<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemapSubMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remap_sub_menus', function (Blueprint $table) {
            $table->increments('id');
			$table->string('remap_sub_menu_name');			
			$table->char('remap_sub_menu_status',1);
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
        Schema::drop('remap_sub_menus');
    }
}
