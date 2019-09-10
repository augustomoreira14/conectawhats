<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {     
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('gateway')->nullable();
            $table->string('link_checkout')->nullable();
            $table->string('checkout_id')->nullable();
            $table->double('total', 8, 2)->nullable();
            $table->string('number')->nullable();
            $table->string('status');
            $table->string('flow');
            $table->text('note')->nullable();
            $table->unsignedInteger('store_id');
            $table->timestamp('followup_at')->nullable();
            $table->timestamp('last_status_at')->nullable();
            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('stores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
