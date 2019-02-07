<?php

namespace App\Services;

use App\Release;

class ReaderService
{
    /**
     * @var null
     */
    private $oJournal = null;

    /**
     * @var null
     */
    private $oArticles = null;

    /**
     * ReaderService constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param Release $oRelease
     * @return $this
     */
    public function byRelease(Release $oRelease): ReaderService
    {
        $this->oJournal = $oRelease->journal;
        $this->oArticles = $oRelease->articles()->with('authors')->get();

        return $this;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            $this->oJournal,
            $this->oArticles,
        ];
    }
}
