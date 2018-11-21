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
            $table->string('language');
            $table->string('chief_editor')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('site')->nullable();
            $table->text('about_editor')->nullable();
            $table->text('contacts')->nullable();
            $table->timestamps();
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
    }
}
