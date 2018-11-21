<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('language')->insert([
            'name' => 'Русский',
            'code' => 'RU'
        ]);
        DB::table('language')->insert([
            'name' => 'English',
            'code' => 'EN'
        ]);
    }
}
