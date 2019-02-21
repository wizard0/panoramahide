<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('owner_type', ['user', 'partner_user']);
            $table->integer('release_id')->unsigned();
            $table->integer('article_id')->unsigned()->nullable()->default(null);
            $table->string('title')->nullable()->default(null);
            $table->integer('scroll')->unsigned()->default(0);
            $table->timestamps();
        });

        Schema::table('bookmarks', function (Blueprint $table) {
            $table->foreign('release_id')->references('id')->on('releases')->onDelete('cascade');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('set null');
        });

        Schema::create('bookmark_user', function (Blueprint $table) {
            $table->unsignedInteger('bookmark_id');
            $table->unsignedInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bookmark_id')->references('id')->on('bookmarks')->onDelete('cascade');

            $table->primary(['bookmark_id', 'user_id']);
        });

        Schema::create('bookmark_partner_user', function (Blueprint $table) {
            $table->unsignedInteger('bookmark_id');
            $table->unsignedInteger('user_id');

            $table->foreign('user_id')->references('id')->on('partner_users')->onDelete('cascade');
            $table->foreign('bookmark_id')->references('id')->on('bookmarks')->onDelete('cascade');

            $table->primary(['bookmark_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('bookmarks');
        Schema::dropIfExists('bookmark_user');
        Schema::dropIfExists('bookmark_partner_user');
        Schema::enableForeignKeyConstraints();
    }
}
