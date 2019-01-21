<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JournalSentArticle extends Model
{
    protected $fillable = ['name', 'email', 'message'];
}
