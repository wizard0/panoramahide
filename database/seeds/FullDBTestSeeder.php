<?php

use Illuminate\Database\Seeder;

class FullDBTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(App\Category::class, 10)->create()->each(function ($category) {
//            $category->journals()->save(factory(App\Journal::class, 10)->create()
//                ->each(function ($journal) {
//                    $journal->contact()->save(factory(App\JournalContact::class)->make());
//                    $journal->releases()->save(factory(\App\Release::class, 10)->create()
//                    ->each(function ($release) {
//                        $release->articles()->save(factory(\App\Article::class, 10)->make());
//                    }));
//                }));
//        });
    }
}
