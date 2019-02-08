<?php

namespace App\Services;

use App\Article;
use App\Journal;
use App\Release;
use Illuminate\Support\Facades\File;

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
     * Release
     */
    private $oRelease;

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
        $this->oRelease = $oRelease;
        return $this;
    }

    /**
     * @return Journal
     */
    public function getJournal(): Journal
    {
        return $this->oRelease->journal;
    }

    /**
     * @return mixed
     */
    public function getArticles()
    {
        $oArticles = $this->oRelease->articles()->with('authors', 'translations', 'authors.translations')->get();

        $oArticles = $oArticles->transform(function ($item) {
            $item->html = $this->getArticleHtml($item);
            return $item;
        });

        return $oArticles;
    }

    /**
     * @return mixed
     */
    public function getLibrary()
    {
        $oReleases = Release::with('translations')->where('id', '<>', $this->oRelease->id)->get();

        $oReleases = $oReleases->transform(function ($item) {

            $item->image = asset('img/covers/9051c8d54a4e0d8c0629ba88c2ff292f.png');

            return $item;
        });

        return $oReleases;
    }

    /**
     * @param $oArticle
     * @return string
     */
    private function getArticleHtml(Article $oArticle): string
    {
        $path = resource_path('views/reader/html/');

        $name = 'article_00'.sprintf("%02d", $oArticle->id);

        $html = $name.'.html';

        $file = $path.$html;

        return File::exists($file) ? trim(file_get_contents($file)) : '';
    }

}
