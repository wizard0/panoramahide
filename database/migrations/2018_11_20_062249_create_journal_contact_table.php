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
        Schema::create('journal_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('journal_contact_translates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('journal_contact_id');
            $table->string('locale')->index();
            $table->string('chief_editor')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('site')->nullable();
            $table->text('about_editor')->nullable();
            $table->text('contacts')->nullable();

            $table->foreign('journal_contact_id')->references('id')->on('journal_contacts');
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
