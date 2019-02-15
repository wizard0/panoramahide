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
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminPagesResponseTest extends TestCase
{
    use DatabaseTransactions;

    public function testAllIndexPagesResponse()
    {
        $admin = factory(User::class)
            ->create()
            ->assignRole('admin');

        $this->actingAs($admin)
            ->get(route('categories.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('publishings.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('authors.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('journals.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('releases.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('articles.index'))
            ->assertOk();
    }

    public function testAllEditPagesResponse()
    {
        $admin = factory(User::class)
            ->create()
            ->assignRole('admin');

        $this->actingAs($admin)
            ->get(route('categories.edit', [Category::first()->id]))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('publishings.edit', [Publishing::first()->id]))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('authors.edit', [Author::first()->id]))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('journals.edit', [Journal::first()->id]))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('releases.edit', [Release::first()->id]))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('articles.edit', [Article::first()->id]))
            ->assertOk();
    }

    public function testAllShowPagesResponse()
    {
        $admin = factory(User::class)
            ->create()
            ->assignRole('admin');

        $category = Category::first();
        $this->actingAs($admin)
            ->get(route('categories.show', [$category->id]))
            ->assertOk()
            ->assertSee($category->journals->first()->name);

        $this->actingAs($admin)
            ->get(route('publishings.show', [Publishing::first()->id]))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('authors.show', [Author::first()->id]))
            ->assertOk();

        $journal = Journal::first();
        $this->actingAs($admin)
            ->get(route('journals.show', [$journal->id]))
            ->assertOk()
            ->assertSee($journal->publishings->first()->name);

        $release = Release::first();
        $this->actingAs($admin)
            ->get(route('releases.show', [$release->id]))
            ->assertOk()
            ->assertSee($release->journal->name);

        $this->actingAs($admin)
            ->get(route('articles.show', [Article::first()->id]))
            ->assertOk();
    }

    public function testAllCreatePagesResponse()
    {
        $admin = factory(User::class)
            ->create()
            ->assignRole('admin');

        $this->actingAs($admin)
            ->get(route('categories.create'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('publishings.create'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('authors.create'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('journals.create'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('releases.create'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('articles.create'))
            ->assertOk();
    }
}
