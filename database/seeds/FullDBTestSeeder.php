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

        factory(App\Category::class, 5)->create()->each(function ($category) {
            $category->journals()->saveMany(factory(App\Journal::class, 10)->create()
                ->each(function ($journal) {
                    $journal->contact()->associate(factory(App\JournalContact::class)->create())->save();
                    factory(App\Release::class, 10)
                        ->create(['journal_id' => $journal->id])
                        ->each(function ($release) {
                            $authors = factory(App\Author::class, 2)->make();
                            $release->articles()->saveMany(factory(App\Article::class, 10)->create()
                                ->each(function ($article) use ($authors) {
                                    $article->authors()->saveMany($authors);
                                }));
                        });
                }));
        });
    }
}
