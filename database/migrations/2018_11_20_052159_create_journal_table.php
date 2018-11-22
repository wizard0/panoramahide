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
        Schema::create('journals', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active')->default(1);
            $table->dateTime('active_date')->nullable();
            $table->string('ISSN')->nullable();
            $table->unsignedInteger('journal_contact_id')->nullable();
            $table->timestamps();
        });

        Schema::create('journal_translates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('journal_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->string('code');
            $table->json('in_HAC_list')->nullable();
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

            $table->unique(['locale', 'code']);

            $table->foreign('journal_id')->references('id')->on('journals');
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
