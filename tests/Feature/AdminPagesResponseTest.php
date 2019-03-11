<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Journal;
use App\Models\Publishing;
use App\Models\Release;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
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

    /**
     * @var Journal
     */
    private $oJournal;

    /**
     * @var Release
     */
    private $oRelease;

    /**
     * @var Publishing
     */
    private $oPublishing;

    /**
     * @var Author
     */
    private $oAuthor;

    /**
     * @var Category
     */
    private $oCategory;

    /**
     * @var Article
     */
    private $oArticle;

    protected function setUp()
    {
        parent::setUp();
        $permission = Permission::where('name', User::PERMISSION_ADMIN)->first();
        $role = Role::where('name', User::ROLE_ADMIN)->first();
        if (is_null($permission) && is_null($role)) {
            (new \RolesAndPermissionsBaseSeeder())->run();
        }

        $this->oCategory = $this->factoryCategory();
        $this->oJournal = $this->factoryJournal();
        $this->oCategory->journals()->attach($this->oJournal->id);

        $this->oArticle = $this->factoryArticle();

        $this->oPublishing = $this->factoryPublishing();
        $this->oPublishing->journals()->attach($this->oJournal->id);

        $this->oRelease = $this->factoryRelease([
            'journal_id' => $this->oJournal->id,
        ]);

        $this->oAuthor = $this->factoryAuthor();

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
            ->get(route('categories.edit', [$this->oCategory->id]))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('publishings.edit', [$this->oPublishing->id]))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('authors.edit', [$this->oAuthor->id]))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('journals.edit', [$this->oJournal->id]))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('releases.edit', [$this->oRelease->id]))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('articles.edit', [$this->oArticle->id]))
            ->assertOk();
    }

    public function testAllShowPagesResponse()
    {
        $this->actingAs($this->admin)
            ->get(route('categories.show', [$this->oCategory->id]))
            ->assertOk()
            ->assertSee($this->oCategory->journals->first()->name);

        $this->actingAs($this->admin)
            ->get(route('publishings.show', [$this->oPublishing->id]))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('authors.show', [$this->oAuthor->id]))
            ->assertOk();

        $journal = Journal::find($this->oJournal->id);
        $this->actingAs($this->admin)
            ->get(route('journals.show', [$journal->id]))
            ->assertOk()
            ->assertSee($journal->publishings->first()->name);

        $release = Release::find($this->oRelease->id);
        $this->actingAs($this->admin)
            ->get(route('releases.show', [$release->id]))
            ->assertOk()
            ->assertSee($release->journal->name);

        $this->actingAs($this->admin)
            ->get(route('articles.show', [$this->oArticle->id]))
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
