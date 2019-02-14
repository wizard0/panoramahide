<?php

namespace App\Models;

use App\Journal;
use App\Publishing;
use App\Release;
use Illuminate\Database\Eloquent\Model;
use DB;

class Promocode extends Model
{
    protected $table = 'promocodes';

    const TYPE_COMMON = 'common';
    const TYPE_ON_JOURNAL = 'on_journal';
    const TYPE_ON_PUBLISHING = 'on_publishing';
    const TYPE_ON_RELEASE = 'on_release';
    const TYPE_PUBL_RELEASE = 'publishing+release';
    const TYPE_CUSTOM = 'custom';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'promocode', 'active', 'type', 'journal_id', 'limit', 'used', 'release_begin', 'release_end', 'release_limit',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function journals()
    {
        return $this->belongsToMany(Journal::class, 'promocode_journal');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function publishings()
    {
        return $this->belongsToMany(Publishing::class, 'promocode_publishing');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function releases()
    {
        return $this->belongsToMany(Release::class, 'promocode_release');
    }












    public static function getOne($id)
    {
        $promocode = self::with('journals', 'publishings', 'releases', 'groups')->find($id);
        return $promocode;
    }

    public static function delOne($id)
    {
        self::destroy($id);
    }

    public static function store($fields)
    {
        $data = ['promocode' => $fields['promocode']];
        foreach (['active', 'type', 'journal_id', 'limit', 'used', 'release_begin', 'release_end', 'release_limit'] as $field) {
            if (!empty($fields[$field]))
                $data[$field] = $fields[$field];
        }

        $promocode = self::create($data);

        if (!empty($fields['journals']))
            $promocode->journals()->sync($fields['journals']);
        if (!empty($fields['publishings']))
            $promocode->publishings()->sync($fields['publishings']);
        if (!empty($fields['releases']))
            $promocode->releases()->sync($fields['releases']);
        if (!empty($fields['groups'])) {
            foreach ($fields['groups'] as $group)
                $promocode->groups()->save(\App\Group::store($group, $promocode->id));
        }

        return $promocode;
    }


    public function groups()
    {
        return $this->hasMany('App\Group')->with('journals');
    }

    public static function updateOne($id, $fields)
    {
        $promocode = self::find($id);
        foreach (['active', 'type', 'journal_id', 'limit', 'used', 'release_begin', 'release_end', 'release_limit'] as $field) {
            if (!empty($fields[$field]))
                $promocode->$field = $fields[$field];
        }

        if (!empty($fields['journals']))
            $promocode->journals()->sync($fields['journals']);
        else
            $promocode->journals()->detach();

        if (!empty($fields['publishings']))
            $promocode->publishings()->sync($fields['publishings']);
        else
            $promocode->publishings()->detach();

        if (!empty($fields['releases']))
            $promocode->releases()->sync($fields['releases']);
        else
            $promocode->releases()->detach();

        $promocode->groups()->delete();
        if (!empty($fields['groups'])) {
            foreach ($fields['groups'] as $group)
                $promocode->groups()->save(\App\Group::store($group, $promocode->id));
        }

        $promocode->save();

        return $promocode;
    }

    public function setActive($status = true)
    {
        $this->active = $status;
        $this->save();
    }

    public function isAvailable()
    {
        if (!$this->active)
            return false;
        if (!$this->limit || !$this->used)
            return true;
        if ($this->used < $this->limit)
            return true;
        return false;
    }

    public function getReleases($group = null)
    {
        $Releases = \App\Release::orderBy('id');
        switch ($this->type) {
            case 'common':
                $Releases->join('journal_publishing', 'releases.journal_id', '=', 'journal_publishing.journal_id')
                    ->whereIn('publishing_id', $this->publishings->pluck('id')->toArray())
                    ->where('promo', true);
                break;
            case 'on_journal':
                $Releases->where('journal_id', $this->journal_id)
                    ->where('promo', true);
                break;
            case 'on_publishing':
                $Releases->join('journal_publishing', 'releases.journal_id', '=', 'journal_publishing.journal_id')
                    ->whereIn('publishing_id', $this->publishings->pluck('id')->toArray());
                if ($this->release_begin)
                    $Releases->where('releases.active_date', '>=', $this->release_begin);
                if ($this->release_end)
                    $Releases->where('releases.active_date', '<=', $this->release_end);
                break;
            case 'on_release':
                $Releases->whereIn('id', $this->releases->pluck('id')->toArray());
                if ($this->release_begin)
                    $Releases->where('releases.active_date', '>=', $this->release_begin);
                if ($this->release_end)
                    $Releases->where('releases.active_date', '<=', $this->release_end);
                if ($this->journal_id)
                    $Releases->where('journal_id', $this->journal_id);
                break;
            case 'publishing+release':
                $Releases->join('journal_publishing', 'releases.journal_id', '=', 'journal_publishing.journal_id')
                    ->whereIn('publishing_id', $this->publishings->pluck('id')->toArray())
                    ->whereIn('id', $this->releases->pluck('id')->toArray());
                if ($this->release_begin)
                    $Releases->where('releases.active_date', '>=', $this->release_begin);
                if ($this->release_end)
                    $Releases->where('releases.active_date', '<=', $this->release_end);
                if ($this->journal_id)
                    $Releases->where('journal_id', $this->journal_id);
                break;
            case 'custom':
                dd($this->groups());
                break;
        }
        return $Releases->get();
    }
}
