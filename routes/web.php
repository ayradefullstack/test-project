<?php

use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/'.SetLocale::FALLBACK_LOCALE);

Route::prefix('{locale}')
    ->where(['locale' => implode('|', SetLocale::SUPPORTED_LOCALES)])
    ->group(function () {
        Route::inertia('/', 'Home')->name('home');
    });

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
