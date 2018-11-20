<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReleaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('release', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->boolean('active');
            $table->dateTime('active_date');
            $table->unsignedInteger('journal_id');
            $table->string('number');
            $table->string('price_for_printed');
            $table->string('price_for_electronic');
            $table->string('image');
            $table->text('description');
            $table->string('preview_image');
            $table->text('preview_description');
            $table->boolean('promo')->comment('Is release available for free');
            $table->string('price_for_articles');
            $table->timestamps();

            $table->unique('code');

            $table->foreign('journal_id')->references('id')->on('journal');
        });

        Schema::create('release_translate', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('release_id');
            $table->string('language');
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('image');
            $table->text('description');
            $table->string('preview_image');
            $table->text('preview_description');
            $table->timestamps();

            $table->unique('code');

            $table->foreign('release_id')->references('id')->on('release');
            $table->foreign('language')->references('code')->on('language');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('release');
        Schema::dropIfExists('release_translate');
    }
}
