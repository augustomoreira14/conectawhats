<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //'shop', 'token', 'plan', 'type', 'user_id'
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shop')->unique();
            $table->string('token');
            $table->string('plan');
            $table->string('type');
            $table->integer('user_id')->nullable()->unsigned();
            $table->boolean('actived');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
