<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
// @codingStandardsIgnoreLine
class CreateReleaseUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('release_user', function (Blueprint $table) {
            $table->unsignedInteger('release_id');
            $table->unsignedInteger('user_id');

            $table->foreign('release_id')->references('id')->on('releases');
            $table->foreign('user_id')->references('id')->on('users');

            $table->primary(['release_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('release_user');
    }
}
