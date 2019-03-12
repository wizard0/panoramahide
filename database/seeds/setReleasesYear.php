<?php

use Illuminate\Database\Seeder;

class SetReleasesYear extends Seeder
{
    /**
     * This seeder is only for test. Do not! run it at staged mode
     *
     * @return void
     */
    public function run()
    {
        $releases = \App\Models\Release::all();
        foreach ($releases as $release) {
            $release->year = rand(2010, 2019);
            $release->save();
        }
    }
}
