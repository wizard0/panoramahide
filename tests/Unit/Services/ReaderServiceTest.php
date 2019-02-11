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

        $oJournal = $oService->getJournal();
        $oArticles = $oService->getArticles();
        $oReleases = $oService->getLibrary();
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

    public function testGetJournal()
    {
        $oService = (new ReaderService())->byRelease($this->release());

        $oJournal = $oService->getJournal();

        $this->assertNotNull($oJournal);
    }

    public function testGetArticles()
    {
        $this->assertTrue(true);
    }

    /**
     * Collection Releases
     */
    public function testGetLibrary()
    {
        $this->assertTrue(true);
    }
}
