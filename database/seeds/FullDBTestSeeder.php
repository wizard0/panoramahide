<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FullDBTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->clear();
        factory(App\Category::class, 5)->create()->each(function ($category) {
            $category->journals()->saveMany(factory(App\Journal::class, 10)->create()
                ->each(function ($journal) {
                    factory(App\Release::class, 10)
                        ->create(['journal_id' => $journal->id])
                        ->each(function ($release) {
                            $authors = factory(App\Author::class, 2)->make();
                            $release->articles()->saveMany(factory(App\Article::class, 10)->create()
                                ->each(function ($article) use ($authors) {
                                    $article->authors()->saveMany($authors);
                                }));
                        });
                    factory(App\Models\Promocode::class, 3)
                        ->create(['journal_id' => $journal->id]);
                }));
        });
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
