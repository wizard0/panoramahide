<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnerUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->boolean('active');
            $table->unsignedInteger('partner_id');
            $table->string('email');
            $table->timestamps();

            $table->unique('user_id');

            $table->foreign('partner_id')->references('id')->on('partner');
        });

        Schema::create('p_users_used_quotas', function (Blueprint $table) {
            $table->unsignedInteger('p_user_id');
            $table->unsignedInteger('quota_id');

            $table->foreign('p_user_id')->references('id')->on('partner_user');
            $table->foreign('quota_id')->references('id')->on('quota');

            $table->primary(['p_user_id', 'quota_id']);
        });

        Schema::create('p_users_avail_releases', function (Blueprint $table) {
            $table->unsignedInteger('p_user_id');
            $table->unsignedInteger('release_id');

            $table->foreign('p_user_id')->references('id')->on('partner_user');
            $table->foreign('release_id')->references('id')->on('release');

            $table->primary(['p_user_id', 'release_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partner_user');
        Schema::dropIfExists('p_users_used_quotas');
        Schema::dropIfExists('p_users_available_quotas');
    }
}
