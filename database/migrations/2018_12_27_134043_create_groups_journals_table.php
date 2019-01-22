<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups_journals', function (Blueprint $table) {
            $table->unsignedInteger('group_id');
            $table->unsignedInteger('journal_id');

            $table->foreign('group_id')->references('group_id')->on('groups');
            $table->foreign('journal_id')->references('id')->on('journals');

            $table->primary(['group_id', 'journal_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups_journals');
    }
}
