<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');
Route::get('/admin', [UserController::class, 'index']);
Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'admin'])->name('dashboard');


require __DIR__ . '/settings.php';

Route::get('/test-seo', function (\App\Services\SeoService $seoService) {
    $model = new \stdClass();
    $model->name = 'Test Product';
    $model->description = 'This is a test product description.';
    $model->meta_title = 'Meta Title Test';
    $model->meta_description = 'Meta Description Test';
    $model->meta_keywords = 'test, seo, laravel';
    $model->og_title = 'OG Title Test';
    $model->og_description = 'OG Description Test';
    $model->og_image = 'https://example.com/image.jpg';
    $model->canonical_url = 'https://example.com/test-product';
    $model->robots = 'index, follow';
    $model->schema_markup = ['key' => 'value'];
    $model->slug = 'test-product';

    $seoService->setFromModel($model);

    return \Artesaos\SEOTools\Facades\SEOTools::generate();
});
