<?php

namespace App\Traits;

use App\Models\Seo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSEO
{
    //boot the trait
    protected static function bootHasSEO(): void
    {
        static::deleting(function ($model) {
            if (!method_exists($model, 'isForceDeleting') || !$model->isForceDeleting()) {
                return;
            }
            $model->seo()->delete();
        });
    }

    // get the seo record
    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, 'seoable');
    }
    //update or create seo record
    public function updateSeo(array $data): Seo
    {
        return $this->seo()->updateOrCreate(['seoable_id' => $this->id, 'seoable_type' => get_class($this)], $data);
    }
    // Get meta title (fallback to name)
    public function getMetaTitleAttribute(): ?string
    {
        return $this->seo?->meta_title ?? $this->name ?? null;;
    }
    // Get meta description (fallback to description)
    public function getMetaDescriptionAttribute(): ?string
    {
        return $this->seo?->meta_description ?? $this->short_description  ?? null;
    }
    //Get meta keywords
    public function getMetaKeywordsAttribute(): ?string
    {
        return $this->seo?->meta_keywords;
    }
    //Get OG description
    public function getOgDescriptionAttribute(): ?string
    {
        return $this->seo?->og_description ?? $this->meta_description;
    }
    //Get OG title
    public function getOgTitleAttribute(): ?string
    {
        return $this->seo?->og_title ?? $this->meta_title;
    }
    //Get canonical URL
    public function getCanonicalUrlAttribute(): ?string
    {
        return $this->seo?->canonical_url;
    }
}
