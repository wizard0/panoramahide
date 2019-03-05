<?php

use Illuminate\Database\Seeder;

class setReleasesActiveDate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $releases = \App\Release::all();
        foreach ($releases as $release) {
            $year = rand(2018, 2019);
            $release->active_date = $year."-".rand(1,12)."-".rand(1,28);
            $release->save();
        }
    }
}
