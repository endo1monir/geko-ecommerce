<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->register(RepositoryServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        config([
            'seotools.meta.defaults.title' => trans('seo.defaults.title'),
            'seotools.meta.defaults.description' => trans('seo.defaults.description'),
            'seotools.opengraph.defaults.title' => trans('seo.og.title'),
            'seotools.opengraph.defaults.description' => trans('seo.og.description'),
            'seotools.json-ld.defaults.title' => trans('seo.json-ld.title'),
            'seotools.json-ld.defaults.description' => trans('seo.json-ld.description'),
        ]);
    }
}
