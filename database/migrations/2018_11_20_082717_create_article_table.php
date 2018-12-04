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
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->boolean('active')->default(1);
            $table->dateTime('active_date')->nullable();
            $table->integer('sort')->nullable();
            $table->unsignedInteger('release_id')->nullable();
            $table->boolean('pin')->default(0);
            $table->enum('content_restriction', ['no', 'register', 'pay/subscribe'])->default('no');
            $table->string('UDC')->nullable()->comment('Universal Decimal Classification');
            $table->string('price')->nullable();
            $table->string('keywords')->nullable()->comment('Just tags');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('preview_image')->nullable();
            $table->text('preview_description')->nullable();
            $table->text('bibliography')->nullable();
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
