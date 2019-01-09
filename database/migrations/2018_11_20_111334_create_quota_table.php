<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotas', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active')->default(1);
            $table->unsignedInteger('partner_id');
            $table->unsignedInteger('journal_id')->nullable();
            $table->unsignedInteger('release_id')->nullable();
            $table->dateTime('release_begin')->nullable()->comment('Access to releases from this date');
            $table->dateTime('release_end')->nullable()->comment('Access to releases to this date');
            $table->unsignedInteger('quota_size')->nullable();
            $table->unsignedInteger('used')->nullable();
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
        Schema::dropIfExists('quotas');
    }
}
