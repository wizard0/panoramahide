<?php

namespace Tests\Unit\Services;

use App\Release;
use App\Services\ReaderService;
use Tests\TestCase;

class ReaderServiceTest extends TestCase
{
    /**
     * Пример использования
     */
    public function example()
    {
        $oService = (new ReaderService())->byRelease($this->release());

        // Журнал релиза
        $oJournal = $oService->getJournal();

        // Статьи релиза
        $oArticles = $oService->getArticles();

        // Другие релизы по релизу
        $oReleases = $oService->getReleases();
    }

    /**
     * @see JournalsTableSeeder
     *
     * @return Release
     */
    private function release(): Release
    {
        return Release::first();
    }

    /**
     * Тест выбрки журнала по релизу
     */
    public function testGetJournal()
    {
        $oService = (new ReaderService())->byRelease($this->release());

        $oJournal = $oService->getJournal();

        $this->assertNotNull($oJournal);
    }

    /**
     * Тестирование выборки статей и нахождения в них html
     */
    public function testGetArticles()
    {
        $oService = (new ReaderService())->byRelease($this->release());

        $oArticles = $oService->getArticles();

        $oArticle = $oArticles->first();

        $this->assertNotNull($oArticle);

        $this->assertNotNull($oArticle->html);
    }

    /**
     * Тест выборки релизов для вкладки Библиотека в читалке
     */
    public function testGetReleases()
    {
        $oService = (new ReaderService())->byRelease($this->release());

        $oReleases = $oService->getReleases();

        $oRelease = $oReleases->first();

        $this->assertNotNull($oRelease);

        $this->assertNotNull($oRelease->image);
    }
}
