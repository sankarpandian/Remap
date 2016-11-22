<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsScriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_scripts', function (Blueprint $table) {
            $table->increments('ls_ScriptId');
			$table->integer('ls_CompanyId');
			$table->integer('ls_BucketId');
			$table->string('ls_ScreenId');
			$table->string('ls_ScriptProduct');
			$table->string('ls_ScriptOne');
			$table->string('ls_ScripTwo');
			$table->string('ls_ScripThree');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lms_scripts');
    }
}
