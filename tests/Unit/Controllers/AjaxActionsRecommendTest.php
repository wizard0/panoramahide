<?php

namespace Tests\Unit\Controllers;

use App\Article;
use App\Journal;
use App\UserSearch;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AjaxActionsRecommendTest extends TestCase
{
    use DatabaseTransactions;

    public function testArticleRecommend()
    {
        $article = Article::where('active', 1)->first();

        $response = $this->post(route('recommend'), [
            'email_from' => 'email.from@email.com',
            'email_to' => 'email.to@email.com',
            'ids' => json_encode([
                ['id' => $article->id, 'type' => UserSearch::TYPE_ARTICLE]
            ])
        ]);

        return $response->assertOk();
    }

    public function testJournalRecommend()
    {
        $journal = Journal::where('active', 1)->first();

        $response = $this->post(route('recommend'), [
            'email_from' => 'email.from@email.com',
            'email_to' => 'email.to@email.com',
            'ids' => json_encode([
                ['id' => $journal->id, 'type' => UserSearch::TYPE_JOURNAL]
            ])
        ]);

        return $response->assertOk();
    }
}
