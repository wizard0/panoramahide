<?php

use Illuminate\Database\Seeder;

// @codingStandardsIgnoreLine
class CreateSubscriptions extends Seeder
{
    /**
     * This seeder is only for test. Do not! run it at staged mode
     *
     * @return void
     */
    public function run()
    {
        $journals = \App\Models\Journal::all();
        foreach ($journals as $j) {
            factory(\App\Models\Subscription::class)->make([
                'journal_id' => $j->id,
                'locale' => App::getLocale(),
                'half_year' => 'first',
                'type' => \App\Models\Subscription::TYPE_ELECTRONIC
            ])->save();
            factory(\App\Models\Subscription::class)->make([
                'journal_id' => $j->id,
                'locale' => App::getLocale(),
                'half_year' => 'second',
                'type' => \App\Models\Subscription::TYPE_ELECTRONIC
            ])->save();
            factory(\App\Models\Subscription::class)->make([
                'journal_id' => $j->id,
                'locale' => App::getLocale(),
                'half_year' => 'first',
                'type' => \App\Models\Subscription::TYPE_PRINTED
            ])->save();
            factory(\App\Models\Subscription::class)->make([
                'journal_id' => $j->id,
                'locale' => App::getLocale(),
                'half_year' => 'second',
                'type' => \App\Models\Subscription::TYPE_PRINTED
            ])->save();
        }
    }
}
