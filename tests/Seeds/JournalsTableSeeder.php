<?php

namespace Tests\Seeds;

use App\Journal;
use App\Models\Promocode;
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

        Promocode::first()->journals()->attach($journal->id);
    }
}
