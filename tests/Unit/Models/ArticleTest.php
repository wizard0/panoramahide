<?php
/**
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author    Денис Парыгин (dyp2000@mail.ru)
 */
namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Article;
use App\Models\UserFavorite;

class ArticleTest extends TestCase
{

    private $user;
    private $article;
    private $userFavorite;

    public function setUp()
    {
        parent::setUp();
        $this->userFavorite = factory(\App\Models\UserFavorite::class)->create();
        $this->user = \App\Models\User::where('id', '=', $this->userFavorite->user_id);
        $this->article = \App\Models\Article::where('id', '=', $this->userFavorite->element_id);
    }

    public function tearDown()
    {
        $this->user->find($this->userFavorite->user_id)->delete();
        $this->article->find($this->userFavorite->element_id)->delete();
        $this->userFavorite->find($this->userFavorite->id)->delete();
        unset($this->userFavorite);
        unset($this->article);
        unset($this->user);
    }

    public function testUserFavorites()
    {
        $res = $this->article->first()->userFavorites();
        $this->assertTrue($res->count() > 0);
    }

    public function testScopeFavorites()
    {
        // авторизация
        $this->actingAs($this->user->first());
        $this->assertAuthenticated();

        $res = $this->article->first()->scopeFavorites();

        $this->assertTrue($res->count() > 0);
    }

    public function testScopeWhereTranslationCode()
    {
        $res = $this->article->first()->scopeWhereTranslationCode($this->article, 'name', 'ru');
        $this->assertNotNull($res);
        $this->article = \App\Models\Article::where('id', '=', $this->userFavorite->element_id);
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
