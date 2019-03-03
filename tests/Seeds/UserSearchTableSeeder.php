<?php

namespace Tests\Seeds;

use App\UserSearch;
use Illuminate\Database\Seeder;

class UserSearchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserSearch::create([
            'id' => 1,
            'user_id' => 1,
            'search_params' => json_encode(
                array(
                    array('name' => 'q', 'value' => 'corrupt'),
                    array('name' => 'search_in', 'value' => 'all'),
                    array('name' => 'journal', 'value' => '2'),
                    array('name' => 'type', 'value' => 'article'),
                    array('name' => 'extend', 'value' => '1')
                )
            ),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
