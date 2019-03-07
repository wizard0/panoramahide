<?php

namespace Tests\Unit\Controllers;

use App\Article;
use App\Journal;
use App\Mail\Recommend;
use App\UserSearch;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\FactoryTrait;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

class AjaxActionsRecommendTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;
    use FactoryTrait;

    public function testArticleRecommend()
    {
        Mail::fake();

        $this->factoryArticle([
            'active' => 1,
        ]);

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

        $this->factoryJournal([
            'active' => 1,
        ]);

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
