<?php

namespace Tests\Seeds;

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => testData()->user['name'],
            'last_name' => testData()->user['name'],
            'email' => testData()->user['email'],
            'phone' => testData()->user['phone'],
            'password' => testData()->user['password'],
        ]);
    }
}
