<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('active');
            $table->dateTime('active_date');
            $table->string('code');
            $table->unsignedInteger('publishing_id');
            $table->unsignedInteger('category_id');
            $table->string('ISSN');
            $table->json('in_HAC_list');
            $table->string('image');
            $table->text('description');
            $table->string('preview_image');
            $table->text('preview_description');
            $table->unsignedInteger('journal_contact_id');
            $table->string('format');
            $table->string('volume');
            $table->string('periodicity');
            $table->text('editorial_board');
            $table->text('article_index');
            $table->text('rubrics');
            $table->text('review_procedure');
            $table->text('article_submission_rules');
            $table->timestamps();

            $table->unique('code');
        });

        Schema::create('journal_translate', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('journal_id');
            $table->string('language');
            $table->string('name');
            $table->string('code');
            $table->json('in_HAC_list');
            $table->string('image');
            $table->text('description');
            $table->string('preview_image');
            $table->text('preview_description');
            $table->string('format');
            $table->string('volume');
            $table->string('periodicity');
            $table->text('editorial_board');
            $table->text('article_index');
            $table->text('rubrics');
            $table->text('review_procedure');
            $table->text('article_submission_rules');
            $table->timestamps();

            $table->unique('code');

            $table->foreign('journal_id')->references('id')->on('journal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal');
        Schema::dropIfExists('journal_translate');
    }
}
