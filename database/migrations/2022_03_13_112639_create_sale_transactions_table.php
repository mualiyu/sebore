<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('org_id')->nullable();
            $table->string('device_id')->nullable();
            $table->string('agent_id')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('item_id')->nullable();
            $table->string('store_id')->nullable();
            $table->string('quantity');
            $table->string('date');
            $table->integer('amount');
            $table->integer('paid_amount')->nullable();
            $table->integer('dept_amount')->nullable();
            $table->string('ref_id');
            $table->string('type');
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
        Schema::dropIfExists('sale_transactions');
    }
}
