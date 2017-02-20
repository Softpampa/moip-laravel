<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoipLaravelUpdateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('moip_subscriptions', function (Blueprint $table) {
            $table->string('link')->nullable()->after('status');
            $table->string('payment_method')->after('status')->default('CREDIT_CARD');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('moip_customer_credit_cards');
    }
}
