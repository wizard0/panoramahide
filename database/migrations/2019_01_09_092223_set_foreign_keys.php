<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// @codingStandardsIgnoreLine
class SetForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');
        });

        Schema::table('quotas', function (Blueprint $table) {
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');
            $table->foreign('release_id')->references('id')->on('releases')->onDelete('cascade');
        });

        Schema::create('partner_user_release', function (Blueprint $table) {
            $table->unsignedInteger('p_user_id');
            $table->unsignedInteger('release_id');

            $table->foreign('p_user_id')->references('id')->on('partner_users')->onDelete('cascade');
            $table->foreign('release_id')->references('id')->on('releases')->onDelete('cascade');

            $table->primary(['p_user_id', 'release_id']);
        });

        Schema::table('promocodes', function (Blueprint $table) {
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');
            $table->foreign('journal_for_releases_id')->references('id')->on('journals')->onDelete('cascade');
        });

        Schema::create('promocode_publishing', function (Blueprint $table) {
            $table->unsignedInteger('promocode_id');
            $table->unsignedInteger('publishing_id');

            $table->foreign('promocode_id')->references('id')->on('promocodes')->onDelete('cascade');
            $table->foreign('publishing_id')->references('id')->on('publishings')->onDelete('cascade');

            $table->primary(['promocode_id', 'publishing_id']);
        });

        Schema::create('promocode_release', function (Blueprint $table) {
            $table->unsignedInteger('promocode_id');
            $table->unsignedInteger('release_id');

            $table->foreign('promocode_id')->references('id')->on('promocodes')->onDelete('cascade');
            $table->foreign('release_id')->references('id')->on('releases')->onDelete('cascade');

            $table->primary(['promocode_id', 'release_id']);
        });

        Schema::create('promocode_journal', function (Blueprint $table) {
            $table->unsignedInteger('promocode_id');
            $table->unsignedInteger('journal_id');

            $table->foreign('promocode_id')->references('id')->on('promocodes')->onDelete('cascade');
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');

            $table->primary(['promocode_id', 'journal_id']);
        });

        Schema::create('promo_user_publishing', function (Blueprint $table) {
            $table->unsignedInteger('promo_user_id');
            $table->unsignedInteger('publishing_id');

            $table->foreign('promo_user_id')->references('id')->on('promo_users')->onDelete('cascade');
            $table->foreign('publishing_id')->references('id')->on('publishings')->onDelete('cascade');

            $table->primary(['promo_user_id', 'publishing_id']);
        });

        Schema::create('promo_user_release', function (Blueprint $table) {
            $table->unsignedInteger('promo_user_id');
            $table->unsignedInteger('release_id');

            $table->foreign('promo_user_id')->references('id')->on('promo_users')->onDelete('cascade');
            $table->foreign('release_id')->references('id')->on('releases')->onDelete('cascade');

            $table->primary(['promo_user_id', 'release_id']);
        });

        Schema::create('jby_promo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('promo_user_id');
            $table->unsignedInteger('promocode_id');
            $table->timestamps();

            $table->foreign('promo_user_id')->references('id')->on('promo_users')->onDelete('cascade');
            $table->foreign('promocode_id')->references('id')->on('promocodes')->onDelete('cascade');
        });

        Schema::create('jby_promo_journal', function (Blueprint $table) {
            $table->unsignedInteger('jby_promo_id');
            $table->unsignedInteger('journal_id');

            $table->foreign('jby_promo_id')->references('id')->on('jby_promo')->onDelete('cascade');
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');

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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign('subscriptions_journal_id_foreign');
        });

        Schema::table('quotas', function (Blueprint $table) {
            $table->dropForeign('quotas_partner_id_foreign');
            $table->dropForeign('quotas_journal_id_foreign');
            $table->dropForeign('quotas_release_id_foreign');
        });

        Schema::dropIfExists('partner_user_release');

        Schema::table('promocodes', function (Blueprint $table) {
            $table->dropForeign('promocodes_journal_id_foreign');
            $table->dropForeign('promocodes_journal_for_releases_id_foreign');
        });

        Schema::dropIfExists('promocode_publishing');
        Schema::dropIfExists('promocode_release');
        Schema::dropIfExists('promocode_journal');

        Schema::dropIfExists('promo_user_publishing');
        Schema::dropIfExists('promo_user_release');

        Schema::disableForeignKeyConstraints();
        Schema::table('jby_promo', function (Blueprint $table) {
            $table->dropForeign('jby_promo_promo_user_id_foreign');
            $table->dropForeign('jby_promo_promocode_id_foreign');
        });
        Schema::dropIfExists('jby_promo');
        Schema::table('jby_promo_journal', function (Blueprint $table) {
            $table->dropForeign('jby_promo_journal_jby_promo_id_foreign');
            $table->dropForeign('jby_promo_journal_journal_id_foreign');
        });
        Schema::dropIfExists('jby_promo_journal');
        Schema::enableForeignKeyConstraints();
    }
}
