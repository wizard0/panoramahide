<?php

use Illuminate\Database\Seeder;

use Tests\Seeds\UsersTableSeeder;
use Tests\Seeds\PromocodesTableSeeder;
use Tests\Seeds\PromoUsersTableSeeder;
use Tests\Seeds\JournalsTableSeeder;
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
        $this->call(JournalsTableSeeder::class);

        $this->call(FullDBTestSeeder::class);

        $this->call(PaysystemSeeder::class);
        $this->call(PaysystemDataSeeder::class);
        $this->call(PublishingTestSeeder::class);
        $this->call(setReleasesYear::class);
        $this->call(CreateSubscriptions::class);
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
}
