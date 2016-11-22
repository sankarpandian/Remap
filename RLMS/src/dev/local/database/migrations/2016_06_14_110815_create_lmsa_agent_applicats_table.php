<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLmsaAgentApplicatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lmsa_agent_applicats', function (Blueprint $table) {
            $table->increments('id');
			$table->string('lmsa_app_type');
			$table->string('lmsa_agentType');
			$table->string('lmsa_agentTsr');
			$table->string('lmsa_agentConfig');
			$table->string('lmsa_agentBranch');
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
        Schema::drop('lmsa_agent_applicats');
    }
}
