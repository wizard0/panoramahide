<?php

namespace Tests\Seeds;

use App\Journal;
use App\Models\Group;
use App\Models\Promocode;
use App\Release;
use Illuminate\Database\Seeder;

class JournalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $journal = Journal::create([
            'active' => 1,
            'active_date' => now()->addYear(),
        ]);

        Journal::create([
            'active' => 1,
            'active_date' => now()->addYear(),
        ]);
        Journal::create([
            'active' => 1,
            'active_date' => now()->addYear(),
        ]);

        $oPromocode = Promocode::first();
        $oPromocode->journals()->attach($journal->id);

        $oPromocode = Promocode::where('type', 'custom')->first();
        $oPromocode->journals()->attach($journal->id);

        $oRelease = Release::create([
            'journal_id' => $journal->id,
            'year' => 2019,
            'active' => 1,
        ]);

        $oGroup = Group::create([
            'promocode_id' => $oPromocode->id,
            'name' => 'Группа',
            'active' => 1
        ]);

        $oGroup->journals()->attach($journal->id);
    }
}
