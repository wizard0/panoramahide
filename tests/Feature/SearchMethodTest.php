<?php

namespace Tests\Feature;

use App\Article;
use App\Category;
use App\Journal;
use App\Release;
use App\UserSearch;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchMethodTest extends TestCase
{
    use DatabaseTransactions;

    public function testSearchCount()
    {
        $requestParams = [
            'search_in' => 'all',
            'q' => 'corrupt'
        ];

        $response = $this->get(route('search', $requestParams));

        $rawQuery = <<<EOL
            SELECT
                article_translations.name as articleName,
                articles.id as articleID,
                article_translations.code as articleCode,
                article_translations.description as articleDescr,
                author_translations.name as authorName,
                authors.id as authorID,
                journal_translations.name as journalName,
                journal_translations.code as journalCode,
                releases.id as releaseID,
                release_translations.name as releaseName,
                release_translations.code as releaseCode,
                release_translations.number as releaseNumber,
                articles.active_date as articleActiveDate,
            CASE
                WHEN article_translations.description like '%corrupt%'
                  THEN article_translations.description
                ELSE null
            END as found
            from `articles` 
            left join `releases` on `articles`.`release_id` = `releases`.`id` left join `journals` on `releases`.`journal_id` = `journals`.`id` left join `article_author` on `article_author`.`article_id` = `articles`.`id` left join `authors` on `article_author`.`author_id` = `authors`.`id` left join `journal_category` on `journal_category`.`journal_id` = `journals`.`id` left join `categories` on `categories`.`id` = `journal_category`.`category_id` left join `journal_translations` on `journals`.`id` = `journal_translations`.`journal_id` left join `release_translations` on `releases`.`id` = `release_translations`.`release_id` left join `article_translations` on `articles`.`id` = `article_translations`.`article_id` left join `author_translations` on `authors`.`id` = `author_translations`.`author_id` left join `category_translations` on `categories`.`id` = `category_translations`.`category_id` 
            where (
              `article_translations`.`name` like '%corrupt%' 
              or `release_translations`.`name` like '%corrupt%' 
              or `article_translations`.`description` like '%corrupt%'
              ) and `journal_translations`.`locale` = 'ru' 
              and `release_translations`.`locale` = 'ru' 
              and `article_translations`.`locale` = 'ru' 
              and `author_translations`.`locale` = 'ru' 
              and `category_translations`.`locale` = 'ru' 
              and `journals`.`active` = 1 
              and `releases`.`active` = 1 
              and `articles`.`active` = 1 
              and `categories`.`active` = 1 
            group by `article_translations`.`code`;

EOL;

        $count = sizeof(DB::select($rawQuery));

        $response->assertSeeText("Найдено $count результата");
    }

    public function testFindArticle()
    {
        $category = factory(Category::class)->create();
        $journal = factory(Journal::class)->create();
        $release = factory(Release::class)->create(['journal_id' => $journal->id]);
        $article = factory(Article::class)->create(['release_id' => $release->id]);

        $article->categories()->save($category);

        $requestParams = [
            'type' => UserSearch::TYPE_ARTICLE,
            'category' => $category->id,
            'journal' => $journal->id,
        ];

        $this
            ->get(route('search', $requestParams))
            ->assertSee($article->name);
    }

    public function testFindCategoryJournal()
    {
        $category = factory(Category::class)->create();
        $journal = factory(Journal::class)->create();
        $journal->categories()->save($category);

        $requestParams = [
            'type' => UserSearch::TYPE_JOURNAL,
            'category' => $category->id,
        ];

        $this
            ->get(route('search', $requestParams))
            ->assertSeeText("Найдено 1")
            ->assertSee($journal->name);
    }
}
