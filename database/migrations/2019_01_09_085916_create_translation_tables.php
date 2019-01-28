<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslationTables extends Migration
{
    /**
     * Create tables:
     * journal_translations
     * category_translations
     * publishing_translations
     * author_translations
     * release_translations
     * article_translations
     * news_translations
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('journal_id');
            $table->string('locale')->index();
            $table->timestamps();

            $table->string('name');
            $table->string('code');
            $table->text('in_HAC_list')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('preview_image')->nullable();
            $table->text('preview_description')->nullable();
            $table->string('format')->nullable();
            $table->string('volume')->nullable();
            $table->string('periodicity')->nullable();
            $table->text('editorial_board')->nullable();
            $table->text('article_index')->nullable();
            $table->text('rubrics')->nullable();
            $table->text('review_procedure')->nullable();
            $table->text('article_submission_rules')->nullable();
            $table->string('chief_editor')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('site')->nullable();
            $table->text('about_editor')->nullable();
            $table->text('contacts')->nullable();

            $table->unique(['journal_id','locale']);
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');
        });

        Schema::create('category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->string('locale')->index();
            $table->timestamps();

            $table->string('name');
            $table->string('code');
            $table->string('image')->nullable();
            $table->text('description')->nullable();

            $table->unique(['category_id','locale']);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });

        Schema::create('publishing_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('publishing_id');
            $table->string('locale')->index();
            $table->timestamps();

            $table->string('name');
            $table->string('code');
            $table->string('image')->nullable();
            $table->text('description')->nullable();

            $table->unique(['publishing_id','locale']);
            $table->foreign('publishing_id')->references('id')->on('publishings')->onDelete('cascade');
        });

        Schema::create('author_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->string('locale')->index();
            $table->timestamps();

            $table->string('name');

            $table->unique(['author_id','locale']);
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
        });

        Schema::create('release_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('release_id');
            $table->string('locale')->index();
            $table->timestamps();

            $table->string('name');
            $table->string('code');
            $table->string('number')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('preview_image')->nullable();
            $table->text('preview_description')->nullable();

            $table->unique(['release_id','locale']);
            $table->foreign('release_id')->references('id')->on('releases')->onDelete('cascade');
        });

        Schema::create('article_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('article_id');
            $table->string('locale')->index();
            $table->timestamps();

            $table->string('name');
            $table->string('code');
            $table->string('keywords')->nullable()->comment('Just tags');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('preview_image')->nullable();
            $table->text('preview_description')->nullable();
            $table->text('bibliography')->nullable();

            $table->unique(['article_id','locale']);
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
        });

        Schema::create('news_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('news_id');
            $table->string('locale')->index();
            $table->timestamps();

            $table->string('name');
            $table->string('code');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->text('preview')->nullable();
            $table->string('preview_image')->nullable();

            $table->unique(['news_id','locale']);
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal_translations');
        Schema::dropIfExists('category_translations');
        Schema::dropIfExists('publishing_translations');
        Schema::dropIfExists('author_translations');
        Schema::dropIfExists('release_translations');
        Schema::dropIfExists('article_translations');
        Schema::dropIfExists('news_translations');
    }
}
