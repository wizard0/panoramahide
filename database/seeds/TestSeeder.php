<?php

use Illuminate\Database\Seeder;

use Tests\Seeds\UsersTableSeeder;
use Tests\Seeds\PromocodesTableSeeder;
use Tests\Seeds\PromoUsersTableSeeder;
use Tests\Seeds\JournalsTableSeeder;
use Tests\Seeds\UserSearchTableSeeder;
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

        $this->call(FullDBTestSeeder::class);

        $this->call(PaysystemSeeder::class);
        $this->call(PaysystemDataSeeder::class);
        $this->call(PublishingTestSeeder::class);
        $this->call(setReleasesYear::class);
        $this->call(CreateSubscriptions::class);
        $this->call(RolesAndPermissionsBaseSeeder::class);
        $this->call(UserSearchTableSeeder::class);

        $this->call(PartnersTableSeeder::class);
        $this->call(PartnerUsersTableSeeder::class);
        $this->call(QuotasTableSeeder::class);
        $this->call(DevicesTableSeeder::class);
    }

    private function clear()
    {
        Schema::disableForeignKeyConstraints();
        foreach (DB::select('SHOW TABLES') as $k => $v) {
            $table = array_values((array)$v)[0];
            if ($table === 'migrations') {
                continue;
            }
            DB::statement('TRUNCATE TABLE `' . $table . '`');
        }
        Schema::enableForeignKeyConstraints();
    }

    private function resetAutoincrement()
    {
        Schema::disableForeignKeyConstraints();
        foreach (DB::select('SHOW TABLES') as $k => $v) {
            $table = array_values((array)$v)[0];
            if ($table === 'migrations') {
                continue;
            }
            $maxId = DB::table($table)->max('id');
            DB::statement('ALTER TABLE `' . $table . '` AUTO_INCREMENT=' . intval($maxId + 1) . ';');
        }
        Schema::enableForeignKeyConstraints();
    }
}
