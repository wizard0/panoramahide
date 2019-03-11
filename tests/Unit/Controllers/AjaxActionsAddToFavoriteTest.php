<?php

namespace Tests\Unit\Controllers;

use App\Models\Article;
use App\Models\Journal;
use App\Models\UserSearch;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\FactoryTrait;
use Tests\TestCase;

class AjaxActionsAddToFavoriteTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;
    use FactoryTrait;

    public function testAddJournalsToFavorite()
    {
        $this->factoryJournal([
            'active' => 1,
        ]);

        $journals = Journal::where('active', 1)->limit(5)->get();
        foreach ($journals as $journal) {
            $data[] = ['id' => $journal->id, 'type' => UserSearch::TYPE_JOURNAL];
        }

        $response = $this->post(route('to.favorite'), [
            'data' => $data
        ]);
        $responseAsUser = $this->actingAs(factory(\App\Models\User::class)->create())->post(route('to.favorite'), [
            'data' => $data
        ]);

        return $responseAsUser->assertOk() && $response->assertStatus(302);
    }

    public function testAddArticlesToFavorite()
    {
        $this->factoryArticle([
            'active' => 1,
        ]);

        $articles = Article::Where('active', 1)->limit(5)->get();
        foreach ($articles as $article) {
            $data[] = ['id' => $article->id, 'type' => UserSearch::TYPE_ARTICLE];
        }

        $response = $this->post(route('to.favorite'), [
            'data' => $data
        ]);
        $responseAsUser = $this->actingAs(factory(\App\Models\User::class)->create())->post(route('to.favorite'), [
            'data' => $data
        ]);

        return $responseAsUser->assertOk() && $response->assertStatus(302);
    }
}
