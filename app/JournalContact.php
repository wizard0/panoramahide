<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class JournalContact extends Model
{
    use Translatable;

    public $translatedAttributes = ['name'];
    protected $fillable = ['code'];

    /**
     * The model with translation of all entities
     *
     * @var string
     */
    protected $translationModel = 'journal_contact_translate';
}
