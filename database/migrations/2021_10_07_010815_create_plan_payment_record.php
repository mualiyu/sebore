<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanPaymentRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_payment_records', function (Blueprint $table) {
            $table->id();
            $table->string('plan_id');
            $table->string('org_id');
            $table->boolean('status');
            $table->string('amount');
            $table->string('ref_num');
            $table->string('transaction_date');
            $table->string('customer_code');
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
        Schema::dropIfExists('plan_payment_records');
    }
}
