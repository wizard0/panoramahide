<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// @codingStandardsIgnoreLine
class CreateOrderEnityUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_legal_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('org_name');
            $table->string('legal_address')->nullable();
            $table->string('INN')->comment('ИНН')->nullable();
            $table->string('KPP')->comment('КПП')->nullable();
            $table->string('l_name')->nullable();
            $table->string('l_surname')->nullable();
            $table->string('l_patronymic')->nullable();
            $table->string('l_email')->nullable();
            $table->string('l_delivery_address')->nullable();
            $table->string('l_phone')->nullable();
            $table->unsignedInteger('user_id')->nullable();
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
        Schema::dropIfExists('order_legal_users');
    }
}
