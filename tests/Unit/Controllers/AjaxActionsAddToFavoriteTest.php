<?php

namespace Tests\Unit\Controllers;

use App\Article;
use App\Journal;
use App\UserSearch;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AjaxActionsAddToFavoriteTest extends TestCase
{
    use DatabaseTransactions;

    public function testAddJournalsToFavorite()
    {
        $journals = Journal::where('active', 1)->limit(5)->get();
        foreach ($journals as $journal) {
            $data[] = ['id' => $journal->id, 'type' => UserSearch::TYPE_JOURNAL];
        }

        $response = $this->post(route('to.favorite'), [
            'data' => $data
        ]);
        $responseAsUser = $this->actingAs(factory(\App\User::class)->create())->post(route('to.favorite'), [
            'data' => $data
        ]);

        return $responseAsUser->assertOk() && $response->assertStatus(302);
    }

    public function testAddArticlesToFavorite()
    {
        $articles = Article::Where('active', 1)->limit(5)->get();
        foreach ($articles as $article) {
            $data[] = ['id' => $article->id, 'type' => UserSearch::TYPE_ARTICLE];
        }

        $response = $this->post(route('to.favorite'), [
            'data' => $data
        ]);
        $responseAsUser = $this->actingAs(factory(\App\User::class)->create())->post(route('to.favorite'), [
            'data' => $data
        ]);

        return $responseAsUser->assertOk() && $response->assertStatus(302);
    }
}
