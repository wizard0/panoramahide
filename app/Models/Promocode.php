<?php

namespace App\Models;

use App\Journal;
use App\Publishing;
use App\Release;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Promocode
 * @package App\Models
 *
 * @property integer $id
 * @property string $promocode
 * @property integer $active
 * @property string $type
 * @property integer $journal_id
 * @property integer $limit
 * @property integer $used
 * @property integer $journal_for_releases_id
 * @property \Carbon\Carbon $release_begin
 * @property \Carbon\Carbon $release_end
 * @property integer $release_limit
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo $journal
 * @property \Illuminate\Database\Eloquent\Relations\BelongsToMany $journals
 * @property \Illuminate\Database\Eloquent\Relations\hasMany $jByPromo
 * @property \Illuminate\Database\Eloquent\Relations\BelongsToMany $publishings
 * @property \Illuminate\Database\Eloquent\Relations\BelongsToMany $releases
 * @property \Illuminate\Database\Eloquent\Relations\HasMany $groups
 *
 * @method static Promocode find(mixed $key, mixed $default)
 */
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jByPromo()
    {
        return $this->hasMany(JbyPromo::class, 'promocode_id');
    }

    /**
     * По journal_id
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function journal()
    {
        return $this->belongsTo(Journal::class);
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups()
    {
        return $this->hasMany(Group::class)->with('journals');
    }

    public function increment($column, $amount = 1, array $extra = [])
    {
        return parent::increment($column, $amount, $extra);
    }
}
