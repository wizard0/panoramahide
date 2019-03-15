<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Promocode;
use App\Models\PromoUser;

class Release extends Model
{
    use Translatable, Traits\WithTranslationTrait;

    public $translatedAttributes = [
        'name', 'code', 'number', 'image', 'description',
        'preview_image', 'preview_description',
        'price_for_electronic', 'price_for_printed', 'price_for_articles'
    ];
    // Ссылка для перехода к читалке
    private $readerLink = null;
    // protected $fillable = ['code'];

    public $rules = [
        'name' => 'required|string',
        'code' => 'required|string'
    ];

    /**
     * Journal the release belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function scopeNewest(Builder $query, $limit = null)
    {
        return (is_numeric($limit))
            ? $this->orderBy('active_date', 'desc')->limit($limit)
            : $this->orderBy('active_date', 'desc');
    }

    public function scopeNewestTranslated(Builder $query, $limit = null)
    {
        return (is_numeric($limit))
            ? $this->orderBy('active_date', 'desc')->limit($limit)->withTranslation()
            : $this->orderBy('active_date', 'desc')->withTranslation();
    }

    public function userHasPermission($User)
    {
        if (preg_match('#.*\\\\(PartnerUser)$#', get_class($User))) {
            // Пользователь партнёра
            return ($User->releases()->find($this->id) != null ? true : false);
        } else {
            // Пользователь партала
            // Если пользователь уже открывал этот журнал - возвращаем true
            if ($User->releases->find($this->id)) {
                return true;
            }
            $result = false;
            // Если это промо юзер
            if ($User->promoUser) {
                // Проверяем, доступен ли этот выпуск по промокодам юзера
                $releases = Release::whereId($this->id);
                $User->promoUser->getReleasesQuery($releases);
                if ($releases->count()) {
                    //Если да, то помечаем выпуск как открытый
                    $this->promoUser()->save($User->promoUser);
                    $result = true;
                }
            }
            // Ищем текущий выпуск среди купленных, в подписках и смотрим на результат поиска в промокодах
            if (self::getReleasesByOrdersQuery($User->orders())->find($this->id) ||
                $User->subscriptionsHasRelease($this) || $result) {
                // Устанавливаем связь release - user, что бы упростить проверки при следующих открытиях
                $this->user()->save($User);
                return true;
            }
            return false;
        }
    }
    public function getLink()
    {
        return route('release', ['journalCode' => $this->journal->code, 'releaseID' => $this->id]);
    }
    // По умолчанию ссылка ведёт прямо на выпуск в читалку
    public function getReaderLink()
    {
        return $this->readerLink ?? route('reader.index', ['release_id' => $this->id]);
    }
    // Можно задать другую ссылку. Например для перехода от партнёра
    public function setReaderLink($link)
    {
        $this->readerLink = $link;
    }
    public function promocode()
    {
        return $this->belongsToMany(Promocode::class);
    }

    public function promoUser()
    {
        return $this->belongsToMany(PromoUser::class);
    }
    public function order()
    {
        return $this->belongsToMany(Order::class, 'order_product', 'release_id', 'order_id');
    }

    public static function getReleasesByOrdersQuery($orders)
    {
        return self::whereHas('order', function ($query) use ($orders) {
               $query->where('status', 'completed')
                     ->whereIn('order_id', $orders->get()->pluck('id'));
        });
    }
}
