<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('user_id');
            $table->string('phone')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('promo_user_promocode', function (Blueprint $table) {
            $table->unsignedInteger('promo_user_id');
            $table->unsignedInteger('promocode_id');

            $table->foreign('promo_user_id')->references('id')->on('promo_users');
            $table->foreign('promocode_id')->references('id')->on('promocodes');

            $table->primary(['promo_user_id', 'promocode_id']);
        });

        Schema::create('promo_user_publishing', function (Blueprint $table) {
            $table->unsignedInteger('promo_user_id');
            $table->unsignedInteger('publishing_id');

            $table->foreign('promo_user_id')->references('id')->on('promo_users');
            $table->foreign('publishing_id')->references('id')->on('publishings');

            $table->primary(['promo_user_id', 'publishing_id']);
        });

        Schema::create('promo_user_release', function (Blueprint $table) {
            $table->unsignedInteger('promo_user_id');
            $table->unsignedInteger('release_id');

            $table->foreign('promo_user_id')->references('id')->on('promo_users');
            $table->foreign('release_id')->references('id')->on('releases');

            $table->primary(['promo_user_id', 'release_id']);
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
