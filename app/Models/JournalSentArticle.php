<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalSentArticle extends Model
{
    protected $fillable = ['name', 'email', 'message'];
}
