<?php

namespace App\Services;


use App\Release;

class ReaderService
{
    /**
     * @var null
     */
    private $oJournal = null;

    public function __construct()
    {

    }

    public function byRelease(Release $oRelease)
    {
        $this->oJournal = $oRelease->journal;

        return $this;
    }

    public function data()
    {
        return [
            $this->oJournal
        ];
    }
}
