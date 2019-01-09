<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromocodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promocodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('promocode');
            $table->boolean('active')->default(1);
            $table->enum('type', [
                'common',
                'on_journal',
                'on_publishing',
                'on_release',
                'publishing+release',
                'custom'
            ]);
            $table->unsignedInteger('journal_id')->nullable();
            $table->unsignedInteger('limit')->nullable();
            $table->unsignedInteger('used')->nullable();
            $table->unsignedInteger('journal_for_releases_id')->nullable();
            $table->dateTime('release_begin')->nullable();
            $table->dateTime('release_end')->nullable();
            $table->unsignedInteger('release_limit')->nullable();
            $table->timestamps();

            $table->unique('promocode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promocodes');
    }
}
