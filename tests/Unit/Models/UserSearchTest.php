<?php

namespace Tests\Unit\Models;

use App\User;
use App\UserSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserSearchModelTest extends TestCase
{
	public function testRetrieve()
	{
        $userSearch = new UserSearch();
        $res = $userSearch->retrieve();

		$user = $this->user();

        // авторизация
        $this->actingAs($user);
        $this->assertAuthenticated();

        $userSearch = new UserSearch();
        $res = $userSearch->retrieve();

		$this->assertTrue(True);
	}

	public function testSearch()
	{
		$this->assertTrue(True);
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
