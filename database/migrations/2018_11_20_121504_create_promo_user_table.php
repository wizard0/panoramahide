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
        Schema::create('promo_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('user_id');
            $table->string('phone');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('promo_users_promocodes', function (Blueprint $table) {
            $table->unsignedInteger('promo_user_id');
            $table->unsignedInteger('promocode_id');

            $table->foreign('promo_user_id')->references('id')->on('promo_user');
            $table->foreign('promocode_id')->references('id')->on('promocode');

            $table->primary(['promo_user_id', 'promocode_id']);
        });

        Schema::create('promo_users_publishings', function (Blueprint $table) {
            $table->unsignedInteger('promo_user_id');
            $table->unsignedInteger('publishing_id');

            $table->foreign('promo_user_id')->references('id')->on('promo_user');
            $table->foreign('publishing_id')->references('id')->on('publishing');

            $table->primary(['promo_user_id', 'publishing_id']);
        });

        Schema::create('promo_users_releases', function (Blueprint $table) {
            $table->unsignedInteger('promo_user_id');
            $table->unsignedInteger('release_id');

            $table->foreign('promo_user_id')->references('id')->on('promo_user');
            $table->foreign('release_id')->references('id')->on('release');

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
        Schema::dropIfExists('promo_user');
    }
}
