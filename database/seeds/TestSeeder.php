<?php

use Illuminate\Database\Seeder;

use Tests\Seeds\UsersTableSeeder;
use Tests\Seeds\PromocodesTableSeeder;
use Tests\Seeds\PromoUsersTableSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->clear();
        $this->call(UsersTableSeeder::class);
        $this->call(PromoUsersTableSeeder::class);
        $this->call(PromocodesTableSeeder::class);
    }

    private function clear()
    {
        Schema::disableForeignKeyConstraints();
        foreach (DB::select('SHOW TABLES') as $k => $v) {
            $table = array_values((array)$v)[0];
            DB::statement('TRUNCATE TABLE `' . $table . '`');
        }
        Schema::enableForeignKeyConstraints();
    }
}
