<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoipLaravelCreateInvoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('moip_invoices', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('moip_id')->unsigned();
			$table->integer('amount')->unsigned();
			$table->string('subscription_code');
			$table->string('status');
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
		Schema::drop('moip_invoices');
	}

}
