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
        Schema::create('promocode', function (Blueprint $table) {
            $table->increments('id');
            $table->string('promocode');
            $table->boolean('active')->default(1);
            $table->enum('type', [
                'common',
                'on_journal',
                'on_publishing',
                'journal+publishing',
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

            $table->foreign('journal_id')->references('id')->on('journal');
            $table->foreign('journal_for_releases_id')->references('id')->on('journal');
        });

        Schema::create('promocodes_publishings', function (Blueprint $table) {
            $table->unsignedInteger('promocode_id');
            $table->unsignedInteger('publishing_id');

            $table->foreign('promocode_id')->references('id')->on('promocode');
            $table->foreign('publishing_id')->references('id')->on('publishing');

            $table->primary(['promocode_id', 'publishing_id']);
        });

        Schema::create('promocodes_releases', function (Blueprint $table) {
            $table->unsignedInteger('promocode_id');
            $table->unsignedInteger('release_id');

            $table->foreign('promocode_id')->references('id')->on('promocode');
            $table->foreign('release_id')->references('id')->on('release');

            $table->primary(['promocode_id', 'release_id']);
        });

        Schema::create('promocodes_journals', function (Blueprint $table) {
            $table->unsignedInteger('promocode_id');
            $table->unsignedInteger('journal_id');

            $table->foreign('promocode_id')->references('id')->on('promocode');
            $table->foreign('journal_id')->references('id')->on('journal');

            $table->primary(['promocode_id', 'journal_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promocode');
    }
}
