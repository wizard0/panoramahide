<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\SearchController;
use App\UserSearch;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchControllerTest extends TestCase
{
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

    public function testWithFullParams()
    {
        foreach ([UserSearch::TYPE_ARTICLE, UserSearch::TYPE_JOURNAL] as $type) {
            $requestParams = [
                'type' => $type,
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
                'sort_by' => 'name',
                'sort_order' => 'desc'
            ];

            $request = new Request();
            $request->merge($requestParams);

            $oSearchController = new SearchController();

            $response = $oSearchController->__invoke($request);
            if (!$response) break;
        }


        if ($response)
            return $this->assertTrue(true);
        else return $this->assertTrue(false);

    }

    public function testWithNoParams()
    {
        $request = new Request();

        $oSearchController = new SearchController();

        $response = $oSearchController->__invoke($request);

        if ($response)
            return $this->assertTrue(true);
        else return $this->assertTrue(false);
    }
}
