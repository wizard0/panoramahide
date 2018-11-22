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
        Schema::table('journals', function (Blueprint $table) {
            $table->foreign('journal_contact_id')->references('id')->on('journal_contacts');
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
