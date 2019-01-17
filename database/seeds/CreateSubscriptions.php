<?php

use Illuminate\Database\Seeder;

class CreateSubscriptions extends Seeder
{
    /**
     * This seeder is only for test. Do not! run it at staged mode
     *
     * @return void
     */
    public function run()
    {
        $journals = \App\Journal::all();
        foreach($journals as $j) {
            factory(\App\Subscription::class)->make([
                'journal_id' => $j->id,
                'type' => \App\Subscription::TYPE_ELECTRONIC
            ])->save();
            factory(\App\Subscription::class)->make([
                'journal_id' => $j->id,
                'type' => \App\Subscription::TYPE_PRINTED
            ])->save();
        }
    }
}
