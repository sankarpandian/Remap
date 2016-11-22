<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsCustomerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_customer_details', function (Blueprint $table) {
            $table->increments('customer_id');
			$table->string('customer_refer_id');
			$table->integer('customer_presence');
			$table->integer('hd_type_id');
			$table->char('title', 3);
			$table->string('first_name',50);
			$table->string('last_name',50);
			$table->string('zipcode',20);
			$table->integer('customer_mode_id');
			$table->integer('hometype_id');
			$table->string('spouse_name',50);
			$table->string('customer_address',100);
			$table->string('customer_city',50);
			$table->string('customer_county',150);
			$table->string('customer_state',50);
			$table->string('apt_unit',11);
			$table->string('customer_territory',10);
			$table->string('customer_cross_street',50);
			$table->string('customer_community',50);
			$table->string('house_color',50);
			$table->string('home_phone',50);
			$table->string('work_phone',50);
			$table->string('cell_phone',50);
			$table->string('work_phone_ext',10);
			$table->string('work_phone_mode',3);
			$table->string('cell_phone_mode',3);
			$table->text('customer_comments');
			$table->string('modify_reason',28);
			$table->string('customer_email_id',50);
			$table->string('inbound_source',20);
			$table->string('siebel_id',30);
			$table->integer('api_status');
			$table->string('lead_generator',50);
			$table->string('open_quote',30);
			$table->integer('oldr_siebel_id_sent');
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
        Schema::drop('lms_customer_details');
    }
}
