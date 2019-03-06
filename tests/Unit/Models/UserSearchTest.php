<?php
/**
 * @copyright
 * @author
 */

namespace Tests\Unit\Models;

use App\User;
use App\UserSearch;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\FactoryTrait;
use Tests\TestCase;

/**
 * Class for user search model test.
 */
class UserSearchTest extends TestCase
{
    use DatabaseTransactions;
    use FactoryTrait;

    /**
     * @var User
     */
    private $user;

    /**
     *
     */
    protected function setUp()
    {
        parent::setUp();
        $this->user = $this->factoryUser();
        UserSearch::create([
            'id' => 1,
            'user_id' => $this->user->id,
            'search_params' => json_encode([
                ['name' => 'q', 'value' => 'corrupt'],
                ['name' => 'search_in', 'value' => 'all'],
                ['name' => 'journal', 'value' => '2'],
                ['name' => 'type', 'value' => 'article'],
                ['name' => 'extend', 'value' => '1'],
            ]),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function testRetrieveGuest()
    {
        $res = UserSearch::retrieve();
        $this->assertEmpty($res);
    }

    public function testRetrieve()
    {
        // авторизация
        $this->actingAs($this->user);
        $this->assertAuthenticated();

        // Creating new data row at DB
        $userSearch = UserSearch::create([
            'user_id' => $this->user->id,
            'search_params' => json_encode([
                ['name' => 'q', 'value' => 'atata'],
                ['name' => 'author', 'value' => 'Gogol'],
                ['name' => 'whoisthebest', 'value' => 'me']
            ])
        ]);
        // Checking data existence
        $this->assertDatabaseHas('user_search', ['id' => $userSearch->id]);


        $res = UserSearch::retrieve();
        $this->assertNotEmpty($res, $this->textRed(' Таблица user_search пуста '));
    }

    public function testSearch()
    {
        // авторизация
        $this->actingAs($this->user);
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
                'sort_order' => 'desc',
            ];

            $res = UserSearch::search($requestParams);
            $this->assertNotEmpty($res);
        }
    }

    public function testSearchWithoutParams()
    {
        // авторизация
        $this->actingAs($this->user);
        $this->assertAuthenticated();

        $res = UserSearch::search(null);
        $this->assertFalse($res);
    }
}
