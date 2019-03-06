<?php

namespace Tests\Feature;

use App\Article;
use App\Category;
use App\Http\Controllers\SearchController;
use App\Journal;
use App\Release;
use App\User;
use App\UserSearch;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchMethodsTest extends TestCase
{
    use DatabaseTransactions;

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

    public function testSearchSave()
    {
        Session::start();
        $user = factory(User::class)->create();
        $data = [
            'type' => UserSearch::TYPE_ARTICLE,
            'q' => 'corrupt',
            'favorite' => 'Y',
            'access' => 'Y',
            'category' => rand(1, 5),
            'journal' => rand(1, 50),
            'author_char' => 'A',
            'author' => 'Sebastian',
            'active_from' => "01.01.2019",
            'active_to' => "06.06.2019",
            'udk' => '123-456',
        ];
        $dataFormatted = [];
        foreach ($data as $key => $value) {
            $dataFormatted[]['name'] = $key;
            $dataFormatted[]['value'] = $value;
        }
        $requestParams = ['data' => $dataFormatted];

        $this->actingAs($user)
            ->post(route('save.search'), $requestParams)
            ->assertOk();

        $this->assertDatabaseHas('user_search', [
            'user_id' => $user->id
        ]);
    }

    public function testSearchDeleteOne()
    {
        $user = factory(User::class)->create();
        $userSearch = UserSearch::create([
            'user_id' => $user->id,
            'search_params' => json_encode([
                ['name' => 'q', 'value' => 'atata'],
                ['name' => 'author', 'value' => 'Gogol'],
                ['name' => 'whoisthebest', 'value' => 'me']
            ])
        ]);

        $this->assertDatabaseHas('user_search', [
            'user_id' => $user->id,
            'id' => $userSearch->id
        ]);

        $this->actingAs($user)
            ->post(route('delete.search'), ['id' => $userSearch->id])
            ->assertOk();

        $this->assertDatabaseMissing('user_search', [
            'id' => $userSearch->id
        ]);
    }

    public function testSearchDeleteAll()
    {
        $user = factory(User::class)->create();
        UserSearch::create(
            [
                'user_id' => $user->id,
                'search_params' => json_encode(['dummydata' => true])
            ],
            [
                'user_id' => $user->id,
                'search_params' => json_encode(['dummydata2' => true])
            ],
            [
                'user_id' => $user->id,
                'search_params' => json_encode(['dummydata3' => true])
            ],
            [
                'user_id' => $user->id,
                'search_params' => json_encode(['dummydata4' => true])
            ]
        );

        $this->assertDatabaseHas('user_search', [
            'user_id' => $user->id
        ]);

        $this->actingAs($user)
            ->post(route('delete.search'), ['id' => 'all'])
            ->assertOk();

        $this->assertDatabaseMissing('user_search', [
            'user_id' => $user->id
        ]);
    }
}
