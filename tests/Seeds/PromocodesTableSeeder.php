<?php

namespace Tests\Seeds;

use App\Models\Promocode;
use Illuminate\Database\Seeder;

class PromocodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $promocode1 = Promocode::create([
            'promocode' => '1',
            'active' => 1,
            'type' => 'common',
            'limit' => 1,
            'used' => 1,
            'release_begin' => now()->subDay(),
            'release_end' => now()->addYear(),
        ]);
        Promocode::create([
            'promocode' => '2',
            'active' => 1,
            'type' => 'common',
            'limit' => 10,
            'used' => 1,
            'release_begin' => now()->subDay(),
            'release_end' => now()->addYear(),
        ]);
        Promocode::create([
            'promocode' => '3',
            'active' => 1,
            'type' => 'common',
            'limit' => 10,
            'used' => 1,
            'release_begin' => now()->subDays(5),
            'release_end' => now()->subDays(4),
        ]);

        $oPromoUser = testData()->promoUser();
        $oPromoUser->promocodes()->attach($promocode1->id);
    }
}
