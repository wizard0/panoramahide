<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublishingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publishing', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('active');
            $table->string('code');
            $table->integer('sort');
            $table->string('image');
            $table->text('description');
            $table->timestamps();

            $table->unique('code');
        });

        Schema::create('publishing_translate', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('publishing_id');
            $table->string('language');
            $table->string('name');
            $table->string('code');
            $table->string('image');
            $table->text('description');
            $table->timestamps();

            $table->unique('code');

            $table->foreign('publishing_id')->references('id')->on('publishing');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publishing');
        Schema::dropIfExists('publishing_translate');
    }
}
