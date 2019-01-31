<?php

namespace Tests\Seeds;

use App\Models\PromoUser;
use App\User;
use Illuminate\Database\Seeder;

class PromoUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PromoUser::create([
            'user_id' => testData()->user()->id,
            'name' => testData()->user['name'],
            'phone' => testData()->user['email'],
        ]);
    }
}
