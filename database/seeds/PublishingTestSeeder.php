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
        factory(\App\Publishing::class, 10)->create()->each(function ($publisher) {
            $journal = \App\Journal::find(rand(1,10));
            $journal->publishings()->attach($publisher);

            $journal = \App\Journal::find(rand(1,10));
            $journal->publishings()->attach($publisher);
        });
    }
}
