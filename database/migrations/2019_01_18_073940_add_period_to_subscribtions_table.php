<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// @codingStandardsIgnoreLine
class AddPeriodToSubscribtionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('period');
        });
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->enum('period', [
                'twice_at_month',
                'once_at_month',
                'once_at_2_months',
                'once_at_3_months',
                'once_at_half_year',
                'once'
            ])->after('half_year')->default('once_at_month');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('period');
        });
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->enum('period', [
                'twice_at_month',
                'once_at_month',
                'once_at_2_months',
                'once_at_3_months',
                'once_at_half_year'
            ])->after('half_year');
        });
    }
}
