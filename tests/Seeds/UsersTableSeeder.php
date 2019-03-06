<?php
/**
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author Дмитрий Поскачей (dposkachei@gmail.com)
 */

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
            'name' => 'Тестовый',
            'last_name' => 'Тестовый',
            'email' => 'test@test.com',
            'phone' => '79998887766',
            'password' => '$2y$10$pf83r3UTfcTuGMCfU0M0neords7hON3fEMAThuxvlwwbDpndd1W72', // testtest
        ]);
    }
}
