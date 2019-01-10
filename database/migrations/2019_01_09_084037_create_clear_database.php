<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClearDatabase extends Migration
{
    /**
     * Create tables:
     * journals
     * categories
     * publishings
     * journal_publishing
     * journal_category
     * authors
     * releases
     * articles
     * article_author
     * article_category
     * news
     * news_publishing
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale')->default('ru');
            $table->boolean('active')->default(1);
            $table->dateTime('active_date')->nullable();
            $table->string('ISSN')->nullable();
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active')->default(1);
            $table->integer('sort')->nullable();
            $table->timestamps();
        });

        Schema::create('publishings', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active')->default(1);
            $table->integer('sort')->nullable();
            $table->timestamps();
        });

        Schema::create('journal_publishing', function (Blueprint $table) {
            $table->unsignedInteger('journal_id');
            $table->unsignedInteger('publishing_id');

            $table->foreign('journal_id')->references('id')->on('journals');
            $table->foreign('publishing_id')->references('id')->on('publishings');

            $table->primary(['journal_id', 'publishing_id']);
        });

        Schema::create('journal_category', function (Blueprint $table) {
            $table->unsignedInteger('journal_id');
            $table->unsignedInteger('category_id');

            $table->foreign('journal_id')->references('id')->on('journals');
            $table->foreign('category_id')->references('id')->on('categories');

            $table->primary(['journal_id', 'category_id']);
        });

        Schema::create('authors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('author_language');
            $table->timestamps();
        });

        Schema::create('releases', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active')->default(1);
            $table->dateTime('active_date')->nullable();
            $table->unsignedInteger('journal_id');
            $table->integer('price_for_printed')->nullable();
            $table->integer('price_for_electronic')->nullable();
            $table->boolean('promo')->nullable()->comment('Is release available for free');
            $table->integer('price_for_articles')->nullable();
            $table->timestamps();

            $table->foreign('journal_id')->references('id')->on('journals');
        });

        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active')->default(1);
            $table->dateTime('active_date')->nullable();
            $table->dateTime('active_end_date')->nullable();
            $table->date('publication_date')->nullable();
            $table->integer('sort')->nullable();
            $table->unsignedInteger('release_id')->nullable();
            $table->boolean('pin')->default(0);
            $table->enum('content_restriction', ['no', 'register', 'pay/subscribe'])->default('no');
            $table->string('UDC')->nullable()->comment('Universal Decimal Classification');
            $table->integer('price')->nullable();
            $table->timestamps();

            $table->foreign('release_id')->references('id')->on('releases');
        });

        Schema::create('article_author', function (Blueprint $table) {
            $table->unsignedInteger('article_id');
            $table->unsignedInteger('author_id');

            $table->foreign('article_id')->references('id')->on('articles');
            $table->foreign('author_id')->references('id')->on('authors');

            $table->primary(['article_id', 'author_id']);
        });

        Schema::create('article_category', function (Blueprint $table) {
            $table->unsignedInteger('article_id');
            $table->unsignedInteger('category_id');

            $table->foreign('article_id')->references('id')->on('articles');
            $table->foreign('category_id')->references('id')->on('categories');

            $table->primary(['article_id', 'category_id']);
        });

        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active')->default(1);
            $table->dateTime('publishing_date')->nullable();
            $table->timestamps();
        });

        Schema::create('news_publishing', function (Blueprint $table) {
            $table->unsignedInteger('news_id');
            $table->unsignedInteger('publishing_id');

            $table->foreign('news_id')->references('id')->on('news');
            $table->foreign('publishing_id')->references('id')->on('publishings');

            $table->primary(['news_id', 'publishing_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journals');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('publishings');
        Schema::dropIfExists('journal_publishing');
        Schema::dropIfExists('journal_category');
        Schema::dropIfExists('authors');
        Schema::dropIfExists('releases');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('article_author');
        Schema::dropIfExists('article_category');
        Schema::dropIfExists('news');
        Schema::dropIfExists('news_publishing');
    }
}
