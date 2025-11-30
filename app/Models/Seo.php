<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Translatable\HasTranslations;

class Seo extends Model
{
    use HasTranslations;

    protected $fillable = [
        'seoable_id',
        'seoable_type',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'canonical_url',
        'robots',
        'schema_markup',
    ];

    public $translatable = [
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
    ];
    protected $casts = [
        'schema_markup' => 'array',
    ];

    //get parent seoable model
    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
    //check if should be indexed
    public function shouldIndex(): bool
    {
        return str_contains($this->robots, 'index');
    }
    //Check if should be followed
    public function shouldFollow(): bool
    {
        return str_contains($this->robots, 'follow');
    }
}
