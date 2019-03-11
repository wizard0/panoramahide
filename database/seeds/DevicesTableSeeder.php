<?php

use Illuminate\Database\Seeder;

use App\Models\PartnerUser;
use App\Models\Device;
use App\Models\User;

class DevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (PartnerUser::inRandomOrder()->limit(50)->get() as $user) {
            $user->createDevice();
            if (rand(0, 1)) {
                $user->createDevice();
            }
        }
        foreach (User::inRandomOrder()->limit(50)->get() as $user) {
            $user->createDevice();
            if (rand(0, 1)) {
                $user->createDevice();
            }
        }
    }
}
