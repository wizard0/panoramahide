<?php

use Illuminate\Database\Seeder;
use App\Models\Partner;

// @codingStandardsIgnoreLine
class PartnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            Partner::create(['secret_key' => md5(rand(0, 999999)), 'active' => rand(0, 1)]);
        }
    }
}
