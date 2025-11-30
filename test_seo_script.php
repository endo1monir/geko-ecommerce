<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$seoService = new \App\Services\SeoService();

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

echo "SEOTools Generate: " . \Artesaos\SEOTools\Facades\SEOTools::generate();
