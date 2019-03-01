<?php
/**
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author    Илья Картунин (ikartunin@gmail.com)
 */
namespace App\Models;

use App\Models\Traits\ActiveField;
use Illuminate\Database\Eloquent\Model;

/**
 * Class for quota.
 */
class Quota extends Model
{
    use ActiveField;

    protected $fillable = [
        'active', 'partner_id', 'journal_id', 'release_id', 'release_begin', 'release_end', 'quota_size'
    ];

    public function isAvailable()
    {
        if (!$this->isActive()) {
            return false;
        }
        if ($this->used < $this->quota_size) {
            return true;
        }
        return false;
    }

    public function use()
    {
        // Проверяем доступность квоты
        if ($this->isAvailable()) {
            $this->used++;
            $this->save();
            return true;
        }
        return false;
    }

    public function getReleases()
    {
        $Releases = \App\Release::where(function ($query) {
            if ($this->journal_id) {
                $query->where('journal_id', $this->journal_id);
                if ($this->release_begin && $this->release_end) {
                    $query->where('active_date', '>=', $this->release_begin)
                          ->where('active_date', '<=', $this->release_end);
                }
            }
        })->orWhere(function ($query) {
            if ($this->release_id) {
                $query->where('id', $this->release_id);
            }
        });
        return $Releases->get();
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
}
