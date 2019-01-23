<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditPromocodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promocodes', function (Blueprint $table) {
            $table->dropForeign('promocodes_journal_for_releases_id_foreign');
            $table->dropColumn('journal_for_releases_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promocodes', function (Blueprint $table) {
            $table->unsignedInteger('journal_for_releases_id')->nullable();
            $table->foreign('journal_for_releases_id')->references('id')->on('journals');
        });
    }
}
