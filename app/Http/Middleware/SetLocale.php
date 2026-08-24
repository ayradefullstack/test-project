<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Locales the site is translated into. Arabic is the fallback.
     *
     * @var list<string>
     */
    public const SUPPORTED_LOCALES = ['ar', 'fr', 'en'];

    public const FALLBACK_LOCALE = 'ar';

    /**
     * Handle an incoming request.
     *
     * Resolves the active locale from the {locale} route segment when present
     * (public, crawlable routes), falling back to the `locale` cookie for
     * routes that are not locale-prefixed (authenticated app area). Shares
     * the resolved locale and its writing direction with both the Blade root
     * view and Inertia.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeLocale = $request->route('locale');

        $locale = in_array($routeLocale, self::SUPPORTED_LOCALES, true)
            ? $routeLocale
            : $this->cookieLocale($request);

        App::setLocale($locale);

        $direction = $locale === 'ar' ? 'rtl' : 'ltr';

        View::share('locale', $locale);
        View::share('direction', $direction);

        if ($routeLocale !== null) {
            Cookie::queue('locale', $locale, 60 * 24 * 365);
        }

        return $next($request);
    }

    private function cookieLocale(Request $request): string
    {
        $cookieLocale = $request->cookie('locale');

        return in_array($cookieLocale, self::SUPPORTED_LOCALES, true)
            ? $cookieLocale
            : self::FALLBACK_LOCALE;
    }
}
