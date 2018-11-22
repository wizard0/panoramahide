<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale')->index();
            $table->unsignedInteger('journal_id');
            $table->boolean('active')->default(1);
            $table->enum('type', ['printed', 'electronic']);
            $table->year('year');
            $table->enum('half_year', ['first', 'second']);
            $table->enum('period', [
                'twice_at_month',
                'once_at_month',
                'once_at_2_months',
                'once_at_3_months',
                'once_at_half_year'
            ]);
            $table->string('price_for_release');
            $table->string('price_for_half_year')->nullable();
            $table->string('price_for_year')->nullable();
            $table->timestamps();

            $table->foreign('journal_id')->references('id')->on('journals');
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
