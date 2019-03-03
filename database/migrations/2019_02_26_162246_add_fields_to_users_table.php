<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('second_name')->nullable()->after('name');
            $table->string('title')->nullable()->after('phone');
            $table->tinyInteger('country')->nullable()->after('title');
            $table->string('notes')->nullable()->after('country');
            $table->date('birthday')->nullable()->after('remember_token');
            $table->tinyInteger('gender')->nullable()->after('phone');
            $table->boolean('agree')->default(true)->after('gender');
            $table->enum('version', ['', 'electronic', 'printed'])->after('agree');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('second_name');
            $table->dropColumn('title');
            $table->dropColumn('country');
            $table->dropColumn('notes');
            $table->dropColumn('birthday');
            $table->dropColumn('gender');
            $table->dropColumn('agree');
            $table->dropColumn('version');
        });
    }
}
