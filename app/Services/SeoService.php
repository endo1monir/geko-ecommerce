<?php

namespace App\Services;

use Artesaos\SEOTools\Facades\JsonLdMulti as JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\URL;

class SeoService
{
    //Set default SEO meta tags
    public function setDefaults(?string $title = null, ?string $description = null): void
    {
        $title = $title ?? config('app.name');
        $description = $description ??  'Your online store for quality products';

        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical(URL::current());
        SEOMeta::addKeyword(['ecommerce', 'online shop', 'products']);

        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setUrl(URL::current());
        OpenGraph::setType('website');
        OpenGraph::setSiteName(config('app.name'));

        TwitterCard::setTitle($title);
        TwitterCard::setSite(config('app.name'));

        JsonLd::setTitle($title);
        JsonLd::setDescription($description);
        JsonLd::setType('website');
    }
    // Set SEO for a model with HasSEO trait
    public function setFromModel($model, ?string $routeName = null)
    {
        // 1. Basic Meta Tags
        $title = $model->meta_title ?? $model->name;
        $description = $model->meta_description ?? $model->description;
        $images = [];
        if ($model->og_image) {
            $images[] = filter_var($model->og_image, FILTER_VALIDATE_URL) ? $model->og_image : asset($model->og_image);
        }

        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        if ($model->meta_keywords) {
            // Handle both array and comma-separated string
            $keywords = is_array($model->meta_keywords) ? $model->meta_keywords : explode(',', $model->meta_keywords);
            SEOMeta::addKeyword($keywords);
        }
        if ($model->robots) {
            SEOMeta::setRobots($model->robots);
        }

        // 2. Canonical URL
        $canonicalUrl = null;
        if ($model->canonical_url) {
            $canonicalUrl = $model->canonical_url;
        } elseif ($routeName && isset($model->slug)) {
            $canonicalUrl = route($routeName, ['slug' => $model->slug]);
        }

        if ($canonicalUrl) {
            SEOMeta::setCanonical($canonicalUrl);
            OpenGraph::setUrl($canonicalUrl);
            JsonLd::setUrl($canonicalUrl);
        } else {
            SEOMeta::setCanonical(URL::current());
            OpenGraph::setUrl(URL::current());
            JsonLd::setUrl(URL::current());
        }


        // 3. OpenGraph
        OpenGraph::setTitle($model->og_title ?? $title);
        OpenGraph::setDescription($model->og_description ?? $description);
        OpenGraph::setSiteName(config('app.name'));
        // OpenGraph::setType('article'); // Or make this dynamic if needed
        if (!empty($images)) {
            OpenGraph::addImages($images);
        }

        // 4. Twitter Card
        TwitterCard::setTitle($model->og_title ?? $title);
        TwitterCard::setDescription($model->og_description ?? $description);
        if (!empty($images)) {
            TwitterCard::setImage($images[0]);
        }

        // 5. JSON-LD
        JsonLd::setTitle($title);
        JsonLd::setDescription($description);
        if (!empty($images)) {
            JsonLd::addImage($images);
        }

        // 6. Custom Schema Markup
        if (!empty($model->schema_markup)) {
            // Assuming schema_markup is an array or JSON string that needs to be added
            // SEOTools doesn't have a direct "append raw schema" easily exposed via facade for everything,
            // but we can try to add values if it matches supported types, or just leave it to specific implementations.
            // For now, let's assume it might be handled separately or we just add it to JsonLd if it fits.
            // A common pattern is to just let the view handle raw schema if it's complex, 
            // or use JsonLd::addValue() for specific keys.

            if (is_array($model->schema_markup)) {
                foreach ($model->schema_markup as $key => $value) {
                    JsonLd::addValue($key, $value);
                }
            }
        }
    }
}
