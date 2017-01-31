<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoipLaravelCreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('moip_subscriptions');
        Schema::create('moip_subscriptions', function (Blueprint $table) {

            $table->increments('id');
            $table->string('code');
            $table->string('status');
            $table->integer('amount')->unsigned();
            $table->string('plan_code');
            $table->string('customer_code');
            $table->date('next_invoice_date');
            $table->date('expiration_date')->nullable();
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
