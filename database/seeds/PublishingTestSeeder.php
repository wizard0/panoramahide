<?php

use Illuminate\Database\Seeder;

class PublishingTestSeeder extends Seeder
{
    /**
     * This seeder is only for test. Do not apply it on staged mode!
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Publishing::class, 10)->create()->each(function ($publisher) {
            $firstJournalID = rand(1, 10);
            $journal = \App\Models\Journal::find($firstJournalID);
            $journal->publishings()->attach($publisher);

            $secondJournalID = rand(1, 10);
            while ($firstJournalID == $secondJournalID) {
                $secondJournalID = rand(1, 10);
            }

            $journal = \App\Models\Journal::find($secondJournalID);
            $journal->publishings()->attach($publisher);
        });
    }
}
