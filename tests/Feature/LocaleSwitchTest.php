<?php

test('switching locale on a non-prefixed page redirects back to that page', function () {
    $response = $this->get(route('locale.switch', ['locale' => 'ar', 'redirect' => '/login']));

    $response->assertRedirect('/login');
    $response->assertCookie('locale', 'ar', encrypted: false);
});

test('the locale cookie is not httpOnly, so the client-side instant switcher can persist it', function () {
    $response = $this->get(route('locale.switch', ['locale' => 'ar', 'redirect' => '/login']));

    $cookie = collect($response->headers->getCookies())
        ->first(fn ($cookie) => $cookie->getName() === 'locale');

    expect($cookie)->not->toBeNull();
    expect($cookie->isHttpOnly())->toBeFalse();
});

test('switching locale preserves the query string of the current page', function () {
    $response = $this->get(route('locale.switch', ['locale' => 'fr', 'redirect' => '/login?foo=bar']));

    $response->assertRedirect('/login?foo=bar');
});

test('switching locale rewrites a leading locale segment on locale-prefixed routes', function () {
    $response = $this->get(route('locale.switch', ['locale' => 'fr', 'redirect' => '/ar']));

    $response->assertRedirect('/fr');
});

test('switching locale falls back to the homepage in the new locale when no redirect is given', function () {
    $response = $this->get(route('locale.switch', ['locale' => 'ar']));

    $response->assertRedirect('/ar');
});

test('switching to an unsupported locale is rejected', function () {
    $response = $this->get('/locale/es?redirect=/login');

    $response->assertNotFound();
});

test('switching locale ignores unsafe redirect targets', function () {
    $response = $this->get(route('locale.switch', ['locale' => 'fr', 'redirect' => 'https://evil.example.com']));

    $response->assertRedirect('/fr');
});
