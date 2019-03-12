<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

trait WithTranslationTrait
{
    public function scopeWithPresetTranslation(Builder $query, $locale)
    {
        $query->with([
            'translations' => function (Relation $query) use ($locale) {
                if ($this->useFallback()) {
                    $countryFallbackLocale = $this->getFallbackLocale($locale); // e.g. de-DE => de
                    $locales = array_unique([$locale, $countryFallbackLocale, $this->getFallbackLocale()]);

                    return $query->whereIn($this->getTranslationsTable() . '.' . $this->getLocaleKey(), $locales);
                }

                return $query->where($this->getTranslationsTable() . '.' . $this->getLocaleKey(), $this->locale());
            },
        ]);
    }
}
