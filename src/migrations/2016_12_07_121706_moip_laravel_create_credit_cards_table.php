<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoipLaravelCreateCreditCardsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moip_customer_credit_cards', function (Blueprint $table) {
        
            $table->increments('id');
            $table->string('customer_code');
            $table->string('holder_name');
            $table->string('first_six_digits');
            $table->string('last_four_digits');
            $table->string('brand');
            $table->string('vault');
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
        Schema::drop('moip_customer_credit_cards');
    }
}
