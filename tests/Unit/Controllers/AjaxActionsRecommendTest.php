<?php

namespace Tests\Unit\Controllers;

use App\Article;
use App\Journal;
use App\Mail\Recommend;
use App\UserSearch;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mail;

class AjaxActionsRecommendTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function testArticleRecommend()
    {
        Mail::fake();

        $article = Article::where('active', 1)->first();

        $response = $this->post(route('recommend'), [
            'email_from' => 'email.from@email.com',
            'email_to' => 'email.to@email.com',
            'ids' => json_encode([
                ['id' => $article->id, 'type' => UserSearch::TYPE_ARTICLE]
            ])
        ]);

        Mail::assertSent(Recommend::class);

        return $response->assertOk();
    }

    public function testJournalRecommend()
    {
        Mail::fake();

        $journal = Journal::where('active', 1)->first();

        $response = $this->post(route('recommend'), [
            'email_from' => 'email.from@email.com',
            'email_to' => 'email.to@email.com',
            'ids' => json_encode([
                ['id' => $journal->id, 'type' => UserSearch::TYPE_JOURNAL]
            ])
        ]);

        Mail::assertSent(Recommend::class);

        return $response->assertOk();
    }
}
