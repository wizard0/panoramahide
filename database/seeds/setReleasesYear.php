<?php

use Illuminate\Database\Seeder;

class setReleasesYear extends Seeder
{
    /**
     * This seeder is only for test. Do not! run it at staged mode
     *
     * @return void
     */
    public function run()
    {
        $releases = \App\Release::all();
        foreach ($releases as $release) {
            $release->year = rand(2010, 2019);
            $release->save();
        }
    }
}
