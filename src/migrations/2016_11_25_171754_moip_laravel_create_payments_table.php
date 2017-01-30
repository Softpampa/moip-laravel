<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoipLaravelCreatePaymentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moip_payments', function (Blueprint $table) {
        
            $table->increments('id');
            $table->integer('amount')->unsigned();
            $table->integer('invoice_id')->unsigned();
            $table->integer('moip_id')->unsigned();
            $table->integer('moip_trans_id')->unsigned();
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
        Schema::drop('moip_payments');
    }
}
