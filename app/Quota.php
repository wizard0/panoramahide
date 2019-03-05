<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quota extends Model
{
    public function partner()
    {
        return $this->belongsTo(Models\Partner::class);
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function release()
    {
        return $this->belongsTo(Release::class);
    }
}
