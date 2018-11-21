<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal', function (Blueprint $table) {
            $table->foreign('journal_contact_id')->references('id')->on('journal_contact');
        });

        Schema::create('journals_publishings', function (Blueprint $table) {
            $table->unsignedInteger('journal_id');
            $table->unsignedInteger('publishing_id');

            $table->foreign('journal_id')->references('id')->on('journal');
            $table->foreign('publishing_id')->references('id')->on('publishing');

            $table->primary(['journal_id', 'publishing_id']);
        });

        Schema::create('journals_categories', function (Blueprint $table) {
            $table->unsignedInteger('journal_id');
            $table->unsignedInteger('category_id');

            $table->foreign('journal_id')->references('id')->on('journal');
            $table->foreign('category_id')->references('id')->on('category');

            $table->primary(['journal_id', 'category_id']);
        });

        Schema::table('journal_translate', function (Blueprint $table) {
            $table->foreign('language')->references('code')->on('language');
        });

        Schema::table('journal_contact', function (Blueprint $table) {
            $table->foreign('language')->references('code')->on('language');
        });

        Schema::table('category_translate', function (Blueprint $table) {
            $table->foreign('language')->references('code')->on('language');
        });

        Schema::table('publishing_translate', function (Blueprint $table) {
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
        //
    }
}
