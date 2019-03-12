<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// @codingStandardsIgnoreLine
class CreateOrderPhysUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_phys_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('patronymic')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('delivery_address')->nullable();
            $table->unsignedInteger('user_id')->nullable();
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
        Schema::dropIfExists('order_phys_users');
    }
}
