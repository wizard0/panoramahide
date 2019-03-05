<?php

namespace Tests\Feature;

use App\Article;
use App\Author;
use App\Category;
use App\Journal;
use App\Publishing;
use App\Release;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\FactoryTrait;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminPagesResponseTest extends TestCase
{
    use DatabaseTransactions;
    use FactoryTrait;

    /**
     * @var User
     */
    private $admin;

    protected function setUp()
    {
        parent::setUp();
        (new \RolesAndPermissionsBaseSeeder())->run();

        $oCategory = $this->factoryCategory();
        $oJournal = $this->factoryJournal();
        $oCategory->journals()->attach($oJournal->id);

        $this->factoryArticle();

        $oPublishing = $this->factoryPublishing();
        $oPublishing->journals()->attach($oJournal->id);

        $this->factoryRelease([
            'journal_id' => $oJournal->id,
        ]);

        $this->factoryAuthor();

        $this->admin = factory(User::class)->create()->assignRole('admin');
    }

    public function testAllIndexPagesResponse()
    {
        $this->actingAs($this->admin)
            ->get(route('categories.index', ['sort_by' => 'name']))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('publishings.index'))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('authors.index'))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('journals.index', ['sort_by' => 'name']))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('releases.index'))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('articles.index'))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('paysystems.index'))
            ->assertOk();
    }

    public function testAllEditPagesResponse()
    {
        $this->actingAs($this->admin)
            ->get(route('categories.edit', [Category::first()->id]))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('publishings.edit', [Publishing::first()->id]))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('authors.edit', [Author::first()->id]))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('journals.edit', [Journal::first()->id]))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('releases.edit', [Release::first()->id]))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('articles.edit', [Article::first()->id]))
            ->assertOk();
    }

    public function testAllShowPagesResponse()
    {
        $category = Category::first();
        $this->actingAs($this->admin)
            ->get(route('categories.show', [$category->id]))
            ->assertOk()
            ->assertSee($category->journals->first()->name);

        $this->actingAs($this->admin)
            ->get(route('publishings.show', [Publishing::first()->id]))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('authors.show', [Author::first()->id]))
            ->assertOk();

        $journal = Journal::first();
        $this->actingAs($this->admin)
            ->get(route('journals.show', [$journal->id]))
            ->assertOk()
            ->assertSee($journal->publishings->first()->name);

        $release = Release::first();
        $this->actingAs($this->admin)
            ->get(route('releases.show', [$release->id]))
            ->assertOk()
            ->assertSee($release->journal->name);

        $this->actingAs($this->admin)
            ->get(route('articles.show', [Article::first()->id]))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('paysystems.show', [1]))
            ->assertOk();
    }

    public function testAllCreatePagesResponse()
    {
        $this->actingAs($this->admin)
            ->get(route('categories.create'))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('publishings.create'))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('authors.create'))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('journals.create'))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('releases.create'))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('articles.create'))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('news.create'))
            ->assertOk();
    }
}
