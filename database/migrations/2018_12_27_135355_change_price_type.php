<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePriceType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function ($table) {
            $table->integer('price')->change();
        });
        Schema::table('orders', function ($table) {
            $table->integer('totalPrice')->change();
        });
        Schema::table('releases', function ($table) {
            $table->integer('price_for_printed')->change();
            $table->integer('price_for_electronic')->change();
            $table->integer('price_for_articles')->change();
        });
        Schema::table('subscriptions', function ($table) {
            $table->integer('price_for_release')->change();
            $table->integer('price_for_half_year')->change();
            $table->integer('price_for_year')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
