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
        $this->command->getOutput()->progressStart(50);
        factory(App\Category::class, 5)->create()->each(function ($category) {
            $journals = [];
            $category->journals()->saveMany(factory(App\Journal::class, 10)->create()
                ->each(function ($journal, $key) use (&$journals) {
                    factory(App\Release::class, 10)
                        ->create(['journal_id' => $journal->id])
                        ->each(function ($release) {
                            $authors = factory(App\Author::class, 2)->make();
                            $release->articles()->saveMany(factory(App\Article::class, 10)->create()
                                ->each(function ($article) use ($authors) {
                                    $article->authors()->saveMany($authors);
                                }));
                        });
                    $journals[] = $journal->id;
                    if ($key !== 0 && $key % 5 === 0) {
                        factory(App\Models\Promocode::class, 1)
                            ->create(['journal_id' => $journal->id])
                            ->each(function ($promocode) use (&$journals) {
                                $group = factory(App\Models\Group::class, 1)->create([
                                    'promocode_id' => $promocode->id,
                                ])->each(function ($group) use (&$journals) {
                                    foreach ($journals as $nJournal) {
                                        $group->journals()->attach($nJournal);
                                    }
                                    $journals = [];
                                });
                            });
                    }
                    $this->command->getOutput()->progressAdvance();
                }));
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
