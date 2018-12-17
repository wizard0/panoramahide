<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaysystemDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paysystem_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->string('code');
            $table->text('value')->nullable();
            $table->enum('type', ['string', 'file'])->default('string');
            $table->unsignedInteger('paysystem_id');
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
        Schema::dropIfExists('paysystem_data');
    }
}
