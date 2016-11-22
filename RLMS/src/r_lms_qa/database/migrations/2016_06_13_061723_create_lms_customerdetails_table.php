<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsCustomerdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_customerdetails', function (Blueprint $table) {
           $table->increments('lcd_CustomerId');
            $table->integer('lcd_Presence');
            $table->integer('lcd_CallById');
            $table->string('lcd_Title');
            $table->string('lcd_FirstName');
            $table->string('lcd_LastName');
            $table->integer('lcd_Zipcode');
            $table->integer('lcd_OwnerTypeId');
            $table->integer('lcd_HomeTypeId');
            $table->string('lcd_CoownerName');
            $table->string('lcd_Address');
            $table->string('lcd_CrossStreet');
            $table->string('lcd_City',50);
            $table->string('lcd_County',50);
            $table->string('lcd_State',50);
            $table->string('lcd_AptUnit',50);
            $table->string('lcd_HousecColor',50);
            $table->string('lcd_EmailAddress',50);
            $table->string('lcd_Community',50);
            $table->string('lcd_HomePhone',50);
            $table->string('lcd_WPTitle',3);
            $table->string('lcd_WorkPhone',10);
            $table->string('lcd_CPTitle',3);
            $table->string('lcd_CellPhone',10);
            $table->string('lcd_Territory',10);
            $table->string('lcd_Comments');
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
        Schema::drop('lms_customerdetails');
    }
}
