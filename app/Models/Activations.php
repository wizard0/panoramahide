<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activations extends Model
{
    protected $table = 'activations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'phone', 'code', 'completed', 'completed_at'
    ];

    public function setCompletedAttribute($value)
    {
        $this->attributes['completed'] = $value;
        $this->attributes['completed_at'] = now();
    }
}
