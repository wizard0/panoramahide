<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TranslatableAllPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('price');
        });
        Schema::table('article_translations', function (Blueprint $table) {
            $table->integer('price')->after('code')->nullable();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('locale')->after('orderList')->default('ru');
            $table->dropColumn('payed');
            $table->dropColumn('left_to_pay');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('payed')->nullable();
            $table->integer('left_to_pay')->nullable();
        });

        Schema::table('releases', function(Blueprint $table) {
            $table->dropColumn('price_for_printed');
            $table->dropColumn('price_for_electronic');
            $table->dropColumn('price_for_articles');
        });
        Schema::table('release_translations', function (Blueprint $table) {
            $table->integer('price_for_printed')->nullable();
            $table->integer('price_for_electronic')->nullable();
            $table->integer('price_for_articles')->nullable();
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('price_for_release');
            $table->dropColumn('price_for_half_year');
            $table->dropColumn('price_for_year');
        });
        Schema::create('subscription_translates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('subscription_id');
            $table->string('locale')->index();
            $table->timestamps();

            $table->integer('price_for_release')->nullable();
            $table->integer('price_for_half_year')->nullable();
            $table->integer('price_for_year')->nullable();
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
