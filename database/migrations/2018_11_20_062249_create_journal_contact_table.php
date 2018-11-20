<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_contact', function (Blueprint $table) {
            $table->increments('id');
            $table->string('chief_editor');
            $table->string('phone');
            $table->string('email');
            $table->string('site');
            $table->text('about_editor');
            $table->text('contacts');
            $table->timestamps();
        });

        Schema::create('journal_contact_translate', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('journal_contact_id');
            $table->string('language');
            $table->string('chief_editor');
            $table->string('phone');
            $table->string('email');
            $table->string('site');
            $table->text('about_editor');
            $table->text('contacts');
            $table->timestamps();

            $table->foreign('journal_contact_id')->references('id')->on('journal_contact');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal_contact');
        Schema::dropIfExists('journal_contact_translate');
    }
}
