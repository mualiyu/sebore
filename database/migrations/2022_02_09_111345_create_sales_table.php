<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('org_id');
            $table->string('marketer_id');
            $table->string('store_keeper_id');
            $table->string('item_id');
            $table->string('store_id');
            $table->string('from');
            $table->string('to')->nullable();
            $table->string('expiration')->nullable();
            $table->integer('amount');
            $table->integer('quantity')->nullable();
            $table->string('ref_num');
            $table->string('status')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
