<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('subscription_id')->nullable();
            $table->unsignedInteger('release_id')->nullable();
            $table->unsignedInteger('article_id')->nullable();
        });

        Schema::table('order_product', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('subscription_id')->references('id')->on('ordered_subscriptions');
            $table->foreign('release_id')->references('id')->on('releases');
            $table->foreign('article_id')->references('id')->on('articles');

            $table->unique(['order_id','subscription_id','release_id','article_id'], 'uniq_order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_product');
    }
}
