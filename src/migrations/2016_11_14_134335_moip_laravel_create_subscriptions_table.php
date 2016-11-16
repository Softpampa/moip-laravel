<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoipLaravelCreateSubscriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('moip_subscriptions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('code');
			$table->string('status');
			$table->integer('amount')->unsigned();
			$table->integer('plan_id')->unsigned();
			$table->integer('customer_id')->unsigned();
			$table->date('next_invoice_date');
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
		Schema::drop('moip_subscriptions');
	}

}
