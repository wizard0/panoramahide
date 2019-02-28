<?php
/**
 * Copyright (c) 2018-2019 "ИД Панорама"
 * Автор модуля: Дмитрий Поскачей (dposkachei@gmail.com)
 */

namespace Tests;


use App\Journal;
use App\Models\Group;
use App\Models\Promocode;
use App\Publishing;
use App\Release;

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
}
