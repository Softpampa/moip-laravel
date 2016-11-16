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
			$table->string('status');
			$table->string('description');
			$table->integer('amount')->unsigned();
			$table->integer('setup_fee')->unsigned();
			$table->integer('max_qty')->unsigned();
			$table->integer('billing_cycles')->unsigned();
			$table->integer('interval_length')->unsigned();
			$table->string('interval_unit', 10)->unsigned();
			$table->boolean('trial_enable')->default(false);
			$table->integer('trial_days')->unsigned();
			$table->boolean('trial_hold_setup_fee');
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
