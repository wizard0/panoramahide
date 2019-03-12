<?php

namespace Tests\Unit\Services;

use App\Models\Article;
use App\Models\Release;
use App\Services\ReaderService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\FactoryTrait;
use Tests\TestCase;

class ReaderServiceTest extends TestCase
{
    use FactoryTrait;
    use DatabaseTransactions;

    /**
     * Пример использования
     */
    public function example()
    {
        $oService = (new ReaderService())->byRelease($this->factoryRelease());

        // Журнал релиза
        $oJournal = $oService->getJournal();

        // Статьи релиза
        $oArticles = $oService->getArticles();

        // Другие релизы по релизу
        $oReleases = $oService->getReleases();
    }

    /**
     * @return ReaderService
     */
    public function service(): ReaderService
    {
        return new ReaderService();
    }

    /**
     * Тест выбрки журнала по релизу
     */
    public function testGetJournal()
    {
        $oJournal = $this->factoryJournal();

        $oRelease = $this->factoryRelease([
            'journal_id' => $oJournal->id,
        ]);

        $oService = $this->service()->setPathToHtml('resources/views/reader/html/')->byRelease($oRelease);

        $oJournal = $oService->getJournal();

        $this->assertNotNull($oJournal);
    }

    /**
     * Тестирование выборки статей и нахождения в них html
     */
    public function testGetArticles()
    {
        $oRelease = $this->factoryRelease();

        $oArticle = $this->factoryArticle([
            'release_id' => $oRelease->id,
        ]);

        $oService = $this->service()->byRelease($oRelease);

        $oArticles = $oService->getArticles();

        $oArticle = $oArticles->first();

        $this->assertTrue($oArticle instanceof Article);

        $this->assertNotNull($oArticle);
    }

    /**
     * Тест выборки релизов для вкладки Библиотека в читалке
     */
    public function testGetReleases()
    {
        $oRelease = $this->factoryRelease();

        $oService = $this->service()->byRelease($oRelease);

        $oRelease = $this->factoryRelease();

        $oReleases = $oService->getReleases();

        $oRelease = $oReleases->first();

        $this->assertTrue($oRelease instanceof Release);

        $this->assertNotNull($oRelease);
    }
}
