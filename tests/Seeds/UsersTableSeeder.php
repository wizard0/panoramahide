<?php

namespace Tests\Seeds;

use App\Models\UserDevice;
use App\Services\DeviceService;
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
        $oUser = User::create([
            'name' => testData()->user['name'],
            'last_name' => testData()->user['name'],
            'email' => testData()->user['email'],
            'phone' => testData()->user['phone'],
            'password' => testData()->user['password'],
        ]);

        UserDevice::create([
            'user_id' => $oUser->id,
            'code' => testData()->userDevice['code'],
            'name' => testData()->userDevice['name'],
            'status' => 1,
        ]);
    }
}
