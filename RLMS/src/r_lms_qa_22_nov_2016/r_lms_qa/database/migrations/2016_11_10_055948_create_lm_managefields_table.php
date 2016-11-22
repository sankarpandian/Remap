<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmManagefieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lm_managefields', function (Blueprint $table) {
            $table->increments('id');
            $table->String("lm_FieldName",200);
            $table->String("lm_FieldClass",200);
            $table->String("lm_FieldID",200);
            $table->String("lm_FieldType",200);
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
        Schema::drop('lm_managefields');
    }
}
