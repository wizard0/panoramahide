<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active')->default(1);
            $table->dateTime('active_date')->nullable();
            $table->integer('sort')->nullable();
            $table->unsignedInteger('release_id')->nullable();
            $table->boolean('pin')->default(0);
            $table->enum('content_restriction', ['no', 'register', 'pay/subscribe'])->default('no');
            $table->string('UDC')->nullable()->comment('Universal Decimal Classification');
            $table->string('price')->nullable();
            $table->timestamps();

            $table->foreign('release_id')->references('id')->on('release');
        });

        Schema::create('article_translate', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('article_id');
            $table->string('language');
            $table->string('name');
            $table->string('code');
            $table->json('keywords')->nullable()->comment('Just tags');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('preview_image')->nullable();
            $table->text('preview_description')->nullable();
            $table->text('bibliography')->nullable();
            $table->string('price')->nullable();
            $table->timestamps();

            $table->unique(['language', 'code']);

            $table->foreign('article_id')->references('id')->on('release');
            $table->foreign('language')->references('code')->on('language');
        });

        Schema::create('articles_authors', function (Blueprint $table) {
            $table->unsignedInteger('article_id');
            $table->unsignedInteger('author_id');

            $table->foreign('article_id')->references('id')->on('article');
            $table->foreign('author_id')->references('id')->on('author');

            $table->primary(['article_id', 'author_id']);
        });

        Schema::create('articles_categories', function (Blueprint $table) {
            $table->unsignedInteger('article_id');
            $table->unsignedInteger('category_id');

            $table->foreign('article_id')->references('id')->on('article');
            $table->foreign('category_id')->references('id')->on('category');

            $table->primary(['article_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles_authors');
        Schema::dropIfExists('articles_categories');
        Schema::dropIfExists('article');
        Schema::dropIfExists('article_translate');
    }
}
