<?php

use App\Http\Controllers\LocaleController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/'.SetLocale::FALLBACK_LOCALE);

Route::get('locale/{locale}', LocaleController::class)
    ->where(['locale' => implode('|', SetLocale::SUPPORTED_LOCALES)])
    ->name('locale.switch');

Route::prefix('{locale}')
    ->where(['locale' => implode('|', SetLocale::SUPPORTED_LOCALES)])
    ->group(function () {
        Route::inertia('/', 'Home')->name('home');
    });

Route::get('/api/wilayas/{wilaya}/communes', function (\App\Models\Wilaya $wilaya) {
    return response()->json(
        $wilaya->communes()->active()->visible()->orderBy('name_fr')->get(['id', 'wilaya_id', 'post_code', 'name_fr', 'name_ar'])
    );
})->name('api.wilayas.communes');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
