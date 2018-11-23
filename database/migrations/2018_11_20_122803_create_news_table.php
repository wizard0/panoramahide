<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->boolean('active')->default(1);
            $table->dateTime('publishing_date')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->text('preview')->nullable();
            $table->string('preview_image')->nullable();
            $table->timestamps();
        });

        Schema::create('news_publishing', function (Blueprint $table) {
            $table->unsignedInteger('news_id');
            $table->unsignedInteger('publishing_id');

            $table->foreign('news_id')->references('id')->on('news');
            $table->foreign('publishing_id')->references('id')->on('publishings');

            $table->primary(['news_id', 'publishing_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
