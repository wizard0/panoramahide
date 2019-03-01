<?php
/**
 * @copyright
 * @author
 */
namespace Tests\Unit\Models;

use App\User;
use App\UserSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Class for user search model test.
 */
class UserSearchModelTest extends TestCase
{
    public function testRetrieveGuest()
    {
        $res = UserSearch::retrieve();
        $this->assertEmpty($res);
    }

    public function testRetrieve()
    {
        // авторизация
        $user = $this->user();
        $this->actingAs($user);
        $this->assertAuthenticated();
        $res = UserSearch::retrieve();
        $this->assertNotEmpty($res, $this->textRed(' Таблица user_search пуста '));
    }

    public function testSearch()
    {
        // авторизация
        $user = $this->user();
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

            $res = UserSearch::search($requestParams);
            $this->assertNotEmpty($res);
        }
    }

    public function testSearchWithoutParams()
    {
        // авторизация
        $user = $this->user();
        $this->actingAs($user);
        $this->assertAuthenticated();

        $res = UserSearch::search(null);
        $this->assertFalse($res);
    }

    /**
     * Тестовый пользователь
     *
     * @return mixed
     */
    private function user() : User
    {
        return testData()->user();
    }
}
