<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaysystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('paysystems')->insert([
            'name' => 'Электронный перевод (ROBOKASSA)',
            'code' => 'robokassa',
        ]);

        DB::table('paysystems')->insert([
            'name' => 'Через Сбербанк',
            'code' => 'sberbank'
        ]);

        DB::table('paysystems')->insert([
            'name' => 'Счет',
            'code' => 'invoice'
        ]);
    }
}
