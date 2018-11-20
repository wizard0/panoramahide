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
            $table->foreign('publishing_id')->references('id')->on('publishing');
            $table->foreign('category_id')->references('id')->on('category');
            $table->foreign('journal_contact_id')->references('id')->on('journal_contact');
        });

        Schema::table('journal_translate', function (Blueprint $table) {
            $table->foreign('language')->references('code')->on('language');
        });

        Schema::table('journal_contact_translate', function (Blueprint $table) {
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
