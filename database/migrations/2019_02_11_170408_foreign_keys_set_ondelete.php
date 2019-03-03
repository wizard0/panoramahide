<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKeysSetOndelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal_publishing', function (Blueprint $table) {
            $table->dropForeign('journal_publishing_publishing_id_foreign');
            $table->dropForeign('journal_publishing_journal_id_foreign');
        });
        Schema::table('journal_publishing', function (Blueprint $table) {
            $table->foreign('publishing_id')->references('id')->on('publishings')->onDelete('cascade');
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');
        });

        Schema::table('journal_category', function (Blueprint $table) {
            $table->dropForeign('journal_category_category_id_foreign');
            $table->dropForeign('journal_category_journal_id_foreign');
        });
        Schema::table('journal_category', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');
        });

        Schema::table('releases', function (Blueprint $table) {
            $table->dropForeign('releases_journal_id_foreign');
        });
        Schema::table('releases', function (Blueprint $table) {
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign('articles_release_id_foreign');
        });
        Schema::table('articles', function (Blueprint $table) {
            $table->foreign('release_id')->references('id')->on('releases')->onDelete('cascade');
        });

        Schema::table('article_author', function (Blueprint $table) {
            $table->dropForeign('article_author_article_id_foreign');
            $table->dropForeign('article_author_author_id_foreign');
        });
        Schema::table('article_author', function (Blueprint $table) {
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
        });

        Schema::table('article_category', function (Blueprint $table) {
            $table->dropForeign('article_category_article_id_foreign');
            $table->dropForeign('article_category_category_id_foreign');
        });
        Schema::table('article_category', function (Blueprint $table) {
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });

        Schema::table('news_publishing', function (Blueprint $table) {
            $table->dropForeign('news_publishing_news_id_foreign');
            $table->dropForeign('news_publishing_publishing_id_foreign');
        });
        Schema::table('news_publishing', function (Blueprint $table) {
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
            $table->foreign('publishing_id')->references('id')->on('publishings')->onDelete('cascade');
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
