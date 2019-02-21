<?php

namespace App\Services;

use App\Article;
use App\Journal;
use App\Models\Bookmark;
use App\Release;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ReaderService
{
    /**
     * Release
     */
    private $oRelease;

    /**
     * Директория с html статьями
     *
     * @var string
     */
    private $pathToHtml = 'resources/views/reader/html/';

    /**
     * ReaderService constructor.
     */
    public function __construct()
    {

    }

    /**
     * Поиск по релизу
     *
     * @param Release $oRelease
     * @return $this
     */
    public function byRelease(Release $oRelease): ReaderService
    {
        $this->oRelease = $oRelease;
        return $this;
    }

    /**
     * Журнал релиза
     *
     * @return Journal
     */
    public function getJournal(): Journal
    {
        return $this->oRelease->journal;
    }

    /**
     * Статьи для читалки по релизу со вставкой html кода
     *
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
     * Статьи для читалки по релизу со вставкой html кода
     *
     * @return mixed
     */
    public function getBookmarks()
    {
        $oUser = Auth::user();

        $oBookmarks = $oUser->bookmarks()
            ->where('release_id', $this->oRelease->id)
            ->orderBy('created_at', 'asc')
            ->get();
        return $oBookmarks;
    }

    /**
     * Релизы для вкладке Библиотека
     *
     * @return mixed
     */
    public function getReleases()
    {
        $oReleases = Release::with('translations')->where('id', '<>', $this->oRelease->id)->get();

        $oReleases = $oReleases->transform(function ($item) {

            $item->image = asset('img/covers/9051c8d54a4e0d8c0629ba88c2ff292f.png');

            return $item;
        });

        return $oReleases;
    }

    /**
     * Директория для html статей
     *
     * @param string $path
     * @return ReaderService
     */
    public function setPathToHtml(string $path): ReaderService
    {
        $this->pathToHtml = $path;

        return $this;
    }

    /**
     * Получить html по статье
     *
     * @param $oArticle
     * @return string
     */
    private function getArticleHtml(Article $oArticle): string
    {
        $path = base_path($this->pathToHtml);

        $name = 'article_00'.sprintf("%02d", $oArticle->id);

        $html = $name.'.html';

        $file = $path.$html;

        return File::exists($file) ? trim(file_get_contents($file)) : null;
    }

    /**
     * Удаление закладки
     *
     * @param $id
     * @return bool
     */
    public function bookmarkDestroy($id)
    {
        $oUser = Auth::user();

        $oBookmark = $oUser->bookmarks()
            ->where('id', $id)
            ->first();

        if (!is_null($oBookmark)) {
            $oBookmark->delete();
        }

        return true;
    }

    /**
     * Создание закладки для пользователя
     *
     * @param array $data
     * @return bool
     */
    public function bookmarkCreate(array $data)
    {
        $oUser = Auth::user();

        $oUser->createBookmark([
            'release_id' => $data['release_id'],
            'article_id' => (int)$data['article_id'],
            'title' => $data['title'],
            'scroll' => $data['scroll'],
        ]);

        return true;
    }

}
