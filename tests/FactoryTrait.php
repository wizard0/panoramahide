<?php
/**
 * Copyright (c) 2018-2019 "ИД Панорама"
 * Автор модуля: Дмитрий Поскачей (dposkachei@gmail.com)
 */

namespace Tests;


use App\Article;
use App\Journal;
use App\Models\Group;
use App\Models\Promocode;
use App\Publishing;
use App\Release;
use App\User;

trait FactoryTrait
{
    /**
     * @param array $data
     * @return Promocode
     */
    protected function factoryPromocode(array $data = []): Promocode
    {
        return factory(Promocode::class)->create($data);
    }

    /**
     * @param array $data
     * @return Journal
     */
    protected function factoryJournal(array $data = []): Journal
    {
        return factory(Journal::class)->create($data);
    }

    /**
     * @param array $data
     * @return Release
     */
    protected function factoryRelease(array $data = []): Release
    {
        if (!isset($data['journal_id'])) {
            $data['journal_id'] = $this->factoryJournal()->id;
        }
        return factory(Release::class)->create($data);
    }

    /**
     * @param array $data
     * @return Publishing
     */
    protected function factoryPublishiing(array $data = []): Publishing
    {
        return factory(Publishing::class)->create($data);
    }

    /**
     * @param array $data
     * @return Group
     */
    protected function factoryGroup(array $data = []): Group
    {
        return factory(Group::class)->create($data);
    }

    /**
     * @param array $data
     * @return Article
     */
    protected function factoryArticle(array $data = []): Article
    {
        return factory(Article::class)->create($data);
    }

    /**
     * @param string $class
     * @param $data
     * @return mixed
     */
    protected function factoryMake(string $class, array $data = [])
    {
        return factory($class)->make($data);
    }

    /**
     * @param array $data
     * @return User
     */
    protected function factoryUser(array $data = []): User
    {
        return factory(User::class)->create($data);
    }
}
