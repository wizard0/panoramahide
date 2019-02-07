<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderedSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordered_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->enum('type', ['printed', 'electronic']);
            $table->string('start_month');
            $table->string('term');
            $table->integer('single_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordered_subscriptions');
    }
}
