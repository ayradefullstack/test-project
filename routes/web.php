<?php

use App\Http\Controllers\LocaleController;
use App\Http\Middleware\SetLocale;
use App\Models\Wilaya;
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

Route::get('/api/wilayas/{wilaya}/communes', function (Wilaya $wilaya) {
    return response()->json(
        $wilaya->communes()->active()->visible()->orderBy('name_fr')->get(['id', 'wilaya_id', 'post_code', 'name_fr', 'name_ar'])
    );
})->name('api.wilayas.communes');

Route::middleware(['auth', 'verified', 'role:author'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::inertia('dashboard', 'admin/Dashboard')->name('dashboard');
});

if (app()->environment('local')) {
    Route::get('/mail/preview', function () {
        return view('mail.corporate', [
            'subject' => 'Vérification de votre compte auteur — ONDA',
            'title' => 'Vérification de votre adresse email',
            'greeting' => 'Bonjour Mohamed Benali / مرحباً محمد بن علي,',
            'introLines' => [
                'Merci d\'avoir créé votre compte sur le Portail Numérique Officiel de l\'Office National des Droits d\'Auteur et Droits Voisins (ONDA).',
                'Afin de sécuriser votre espace et d\'activer l\'ensemble des démarches en ligne, veuillez confirmer votre adresse email en cliquant sur le bouton ci-dessous.',
            ],
            'showFeatures' => true,
            'featuresTitle' => 'Avantages & Garanties Numériques ONDA',
            'feature1Title' => 'Protection Juridique Immédiate',
            'feature1Desc' => 'Horodatage souverain et enregistrement légal de vos créations intellectuelles.',
            'feature2Title' => 'Certificats & Déclarations Numériques',
            'feature2Desc' => 'Accès instantané à vos attestations de dépôt et suivi de vos droits financiers.',
            'feature3Title' => 'Hébergement Souverain et Crypté',
            'feature3Desc' => 'Vos données et fichiers sont hébergés sur des serveurs sécurisés en Algérie.',
            'actionText' => 'Activer et vérifier mon compte',
            'actionUrl' => url('/email/verify/sample-token'),
            'warningTitle' => 'Avis de Sécurité / تنبيه أمني',
            'warningText' => 'Si vous n\'avez pas créé de compte sur le portail ONDA, veuillez ignorer cet email. Ne communiquez jamais vos identifiants ou liens de vérification.',
            'outroLines' => [
                'Pour toute assistance, contactez le support technique ONDA à contact@onda.dz.',
                'Cordialement,',
                'Direction des Systèmes d\'Information — ONDA Algérie',
            ],
        ]);
    })->name('mail.preview');
}

require __DIR__.'/settings.php';
