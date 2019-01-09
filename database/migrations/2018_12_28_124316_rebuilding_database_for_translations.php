<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RebuildingDatabaseForTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_translates', function (Blueprint $table) {
            foreach ((new \App\Article())->translatable as $columnName) {
                $columnType = DB::connection()
                    ->getDoctrineColumn('articles', $columnName)
                    ->getType()
                    ->getName();

                $table->$columnType($columnName);
            }
        });
        Schema::table('articles', function (Blueprint $table) {
            foreach ((new \App\Article())->translatable as $columnName)
                $table->dropColumn($columnName);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
