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
            $table->increments('id');
            $table->unsignedInteger('phys_user_id')->nullable();
            $table->unsignedInteger('legal_user_id')->nullable();
            $table->unsignedInteger('paysystem_id');
            $table->enum('status', [
                'wait', 'payed', 'cancelled', 'completed'
            ])->default('wait');
            $table->json('orderList');
            $table->integer('totalPrice');
            $table->string('payed');
            $table->string('left_to_pay');
            $table->timestamps();

            $table->foreign('paysystem_id')->references('id')->on('paysystems');
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
