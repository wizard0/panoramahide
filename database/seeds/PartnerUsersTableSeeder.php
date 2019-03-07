<?php

use Illuminate\Database\Seeder;
use App\Models\Partner;
use App\Models\PartnerUser;

class PartnerUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Partner::inRandomOrder()->get() as $partner) {
            for ($i=0; $i < 10; $i++) {
                try {
                    PartnerUser::create(['user_id' => md5(rand(0,999999)), 'active' => rand(0,1), 'partner_id' => $partner->id]);
                } catch (\Exception $e) {
                    // перехват Duplicate entry partner_users_user_id_unique
                }
            }
        }
    }
}
