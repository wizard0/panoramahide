<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('owner_type', ['user', 'partner_user']);
            $table->boolean('active')->default(false);
            $table->dateTime('activate_date')->nullable();
            $table->string('activate_code')->nullable();
            $table->dateTime('online_datetime')->nullable();

            $table->timestamps();
        });

        Schema::create('device_user', function (Blueprint $table) {
            $table->unsignedInteger('device_id');
            $table->unsignedInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('device_id')->references('id')->on('devices');

            $table->primary(['device_id', 'user_id']);
        });

        Schema::create('device_partner_user', function (Blueprint $table) {
            $table->unsignedInteger('device_id');
            $table->unsignedInteger('user_id');

            $table->foreign('user_id')->references('id')->on('partner_users');
            $table->foreign('device_id')->references('id')->on('devices');

            $table->primary(['device_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('device_user');
        Schema::dropIfExists('device_partner_user');
        Schema::dropIfExists('devices');
        Schema::enableForeignKeyConstraints();
    }
}
