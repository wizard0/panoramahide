<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_devices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->integer('code');
            $table->string('name');
            $table->timestamp('code_at')->nullable()->default(null);
            $table->timestamp('expires_at')->nullable()->default(null);
            $table->tinyInteger('is_online')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::table('user_devices', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_devices', function($table) {
            $table->dropForeign('user_devices_user_id_foreign');
        });
        Schema::dropIfExists('user_devices');
    }
}
