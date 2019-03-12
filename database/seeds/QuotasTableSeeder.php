<?php

use Illuminate\Database\Seeder;
use App\Models\Release;
use App\Models\Journal;
use App\Models\Partner;
use App\Models\PartnerUser;
use App\Models\Quota;

// @codingStandardsIgnoreLine
class QuotasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Partner::inRandomOrder()->get() as $partner) {
            for ($i = 0; $i < 100; $i++) {
                $newQuata = ['active' => mt_rand(0, 1)];
                $newQuata['partner_id'] = $partner->id;
                if (mt_rand(0, 1)) {
                    $newQuata['journal_id'] = Journal::inRandomOrder()->get()->first()->id;
                    if (mt_rand(0, 1)) {
                        $newQuata['release_begin'] = '2018-' . mt_rand(1, 6) . '-' . mt_rand(1, 28) . ' 00:00:00';
                        $newQuata['release_end'] = '2018-' . mt_rand(7, 12) . '-' . mt_rand(1, 30) . ' 00:00:00';
                    }
                }
                if (mt_rand(0, 1) || empty($newQuata['journal_id'])) {
                    $newQuata['release_id'] = Release::inRandomOrder()->get()->first()->id;
                }
                $newQuata['quota_size'] = mt_rand(1, 99);
                Quota::create($newQuata);
            }
        }
    }
}
