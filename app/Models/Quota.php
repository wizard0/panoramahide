<?php

namespace App\Models;

use App\Traits\ActiveField;
use Illuminate\Database\Eloquent\Model;

class Quota extends Model
{
    use ActiveField;

    protected $fillable = [
        'active', 'partner_id', 'journal_id', 'release_id', 'release_begin', 'release_end', 'quota_size'
    ];

    public function isAvailable()
    {
        if (!$this->isActive())
            return false;
        if (!$this->quota_size || !$this->used)
            return true;
        if ($this->used < $this->quota_size)
            return true;
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
        })->orWhere(function($query) {
            if ($this->release_id) {
                $query->where('id', $this->release_id);
            }
        });
        return $Releases->get();
    }

    public function partner()
    {
        return $this->hasOne(Partner::class);
    }
    public function journal()
    {
        return $this->hasOne(Journal::class);
    }
    public function release()
    {
        return $this->hasOne(Release::class);
    }
}
