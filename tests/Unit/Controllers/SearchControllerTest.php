<?php

namespace Tests\Unit\Controllers;

use App\User;
use App\UserSearch;
use App\Http\Controllers\SearchController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\FactoryTrait;
use Tests\TestCase;

class SearchControllerTest extends TestCase
{
    use DatabaseTransactions;
    use FactoryTrait;

    private $allSearchParams = [
        'type',
        'q',
        'favorite',
        'access',
        'category',
        'journal',
        'author_char',
        'author',
        'active_from',
        'active_to',
        'udk',
        'sort_by',
        'sort_order'
    ];

    public function testSerachArticleGuest()
    {
        foreach (['name', 'date'] as $sort) {
            $requestParams = [
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
                'sort_by' => $sort,
                'sort_order' => 'desc'
            ];

            $request = new Request();
            $request->merge($requestParams);

            $oSearchController = new SearchController();

            $response = $oSearchController->__invoke($request);
            $this->assertNotNull($response);
        }
    }

    public function testSerachJournalGuest()
    {
        foreach (['name', 'date'] as $sort) {
            $requestParams = [
                'type' => UserSearch::TYPE_JOURNAL,
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
                'sort_by' => $sort,
                'sort_order' => 'desc'
            ];

            $request = new Request();
            $request->merge($requestParams);

            $oSearchController = new SearchController();

            $response = $oSearchController->__invoke($request);
            $this->assertNotNull($response);
        }
    }

    public function testSerachArticleAuthUser()
    {
        $user = $this->user();

        // авторизация
        $this->actingAs($user);
        $this->assertAuthenticated();

        foreach (['name', 'date'] as $sort) {
            $requestParams = [
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
                'sort_by' => $sort,
                'sort_order' => 'desc'
            ];

            $request = new Request();
            $request->merge($requestParams);

            $oSearchController = new SearchController();

            $response = $oSearchController->__invoke($request);
            $this->assertNotNull($response);
        }
    }

    public function testWithNoParams()
    {
        $request = new Request();
        $oSearchController = new SearchController();
        $response = $oSearchController->__invoke($request);
        $this->assertNotNull($response);
    }

    /**
     * Тестовый пользователь
     *
     * @return mixed
     */
    private function user() : User
    {
        return $this->factoryUser();
    }
}
