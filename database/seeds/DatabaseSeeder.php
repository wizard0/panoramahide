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
        $this->call(FullDBTestSeeder::class);
        $this->call(\Tests\Seeds\UsersTableSeeder::class);
        $this->call(\Tests\Seeds\PromoUsersTableSeeder::class);
    }
}
