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
        Schema::create('partner_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->boolean('active')->default(1);
            $table->unsignedInteger('partner_id');
            $table->string('email')->nullable();
            $table->timestamps();

            $table->unique('user_id');

            $table->foreign('partner_id')->references('id')->on('partners');
        });

        Schema::create('partner_user_quota', function (Blueprint $table) {
            $table->unsignedInteger('p_user_id');
            $table->unsignedInteger('quota_id');

            $table->foreign('p_user_id')->references('id')->on('partner_users');
            $table->foreign('quota_id')->references('id')->on('quotas');

            $table->primary(['p_user_id', 'quota_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partner_users');
        Schema::dropIfExists('partner_user_quota');
    }
}
