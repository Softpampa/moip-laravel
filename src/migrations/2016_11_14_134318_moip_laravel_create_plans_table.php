<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoipLaravelCreatePlansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('moip_plans', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('code');
			$table->string('name');
			$table->string('status')->default('ACTIVE');
			$table->string('description');
			$table->integer('amount')->unsigned();
			$table->integer('setup_fee')->unsigned()->nullable();
			$table->integer('max_qty')->unsigned()->nullable();
			$table->integer('billing_cycles')->unsigned()->nullable();
			$table->integer('interval_length')->unsigned()->default(1);
			$table->string('interval_unit', 10)->unsigned()->default('MONTH');
			$table->boolean('trial_enable')->default(false);
			$table->integer('trial_days')->unsigned()->nullable();
			$table->boolean('trial_hold_setup_fee')->default(false);
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
		Schema::drop('moip_plans');
	}

}
