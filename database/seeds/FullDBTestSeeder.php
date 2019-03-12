<?php

// namespace Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// @codingStandardsIgnoreLine
class FullDBTestSeeder extends Seeder
{
    const CATEGORIES = 5;
    const JOURNALS   = 5;
    const RELEASES   = 5;
    const AUTHORS    = 2;
    const ARTICLES   = 5;
    const TOTAL      = FullDBTestSeeder::ARTICLES * FullDBTestSeeder::RELEASES * FullDBTestSeeder::JOURNALS * FullDBTestSeeder::CATEGORIES;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $this->clear();
        $this->command->getOutput()->progressStart(FullDBTestSeeder::TOTAL);
        factory(App\Models\Category::class, FullDBTestSeeder::CATEGORIES) // 5
            ->create()
            ->each(function ($category) {
                $journals = [];
                $category->journals()->saveMany(
                    factory(App\Models\Journal::class, FullDBTestSeeder::JOURNALS) // 5
                    ->create()
                    ->each(function ($journal, $key) use (&$journals) {
                        factory(App\Models\Release::class, FullDBTestSeeder::RELEASES) // 5
                        ->create(['journal_id' => $journal->id])
                        ->each(function ($release) {
                            $authors = factory(App\Models\Author::class, FullDBTestSeeder::AUTHORS)->make();
                            $release->articles()->saveMany(factory(App\Models\Article::class, FullDBTestSeeder::ARTICLES) // 5
                                ->create()
                                ->each(function ($article) use ($authors) {
                                    $article->authors()->saveMany($authors);
                                    $this->command->getOutput()->progressAdvance();
                                }));
                        });
                        $journals[] = $journal->id;
                        if ($key !== 0 && $key % 5 === 0) {
                            factory(App\Models\Promocode::class, 1)
                                ->create(['journal_id' => $journal->id])
                                ->each(function ($promocode) use (&$journals) {
                                    $group = factory(App\Models\Group::class, 1)
                                        ->create(['promocode_id' => $promocode->id,])
                                        ->each(function ($group) use (&$journals) {
                                            foreach ($journals as $nJournal) {
                                                $group->journals()->attach($nJournal);
                                            }
                                            $journals = [];
                                        });
                                });
                        } // if
                    })
                );
            });
        $this->command->getOutput()->progressFinish();
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
