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
            $table->boolean('active')->default(1);
            $table->dateTime('active_date')->nullable();
            $table->unsignedInteger('journal_id');
            $table->string('number')->nullable();
            $table->string('price_for_printed')->nullable();
            $table->string('price_for_electronic')->nullable();
            $table->boolean('promo')->nullable()->comment('Is release available for free');
            $table->string('price_for_articles')->nullable();
            $table->timestamps();

            $table->foreign('journal_id')->references('id')->on('journal');
        });

        Schema::create('release_translate', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('release_id');
            $table->string('language');
            $table->string('name');
            $table->string('code');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('preview_image')->nullable();
            $table->text('preview_description')->nullable();
            $table->timestamps();

            $table->unique(['language', 'code']);

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
