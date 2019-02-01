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

        $this->call(PaysystemSeeder::class);
        $this->call(PaysystemDataSeeder::class);

        // Test
        $this->call(PublishingTestSeeder::class);
        $this->call(setReleasesYear::class);
        $this->call(CreateSubscriptions::class);
    }
}
