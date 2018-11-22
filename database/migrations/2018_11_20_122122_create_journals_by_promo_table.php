<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalsByPromoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jby_promo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('promo_user_id');
            $table->unsignedInteger('promocode_id');
            $table->timestamps();

            $table->foreign('promo_user_id')->references('id')->on('promo_users');
            $table->foreign('promocode_id')->references('id')->on('promocodes');
        });

        Schema::create('jby_promo_journal', function (Blueprint $table) {
            $table->unsignedInteger('jby_promo_id');
            $table->unsignedInteger('journal_id');

            $table->foreign('jby_promo_id')->references('id')->on('jby_promo');
            $table->foreign('journal_id')->references('id')->on('journals');

            $table->primary(['jby_promo_id', 'journal_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
