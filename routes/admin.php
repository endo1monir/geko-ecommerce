<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Dashboard');
});
//language switcher route
Route::get('lang/{locale}', function ($locale) {
    
    if (!in_array($locale, ['ar', 'en'])) {
        $locale = 'en';
    }
    app()->setLocale($locale);
    session(['locale' => $locale]);
    return redirect()->back();
});
