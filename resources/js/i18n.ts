import { createI18n } from 'vue-i18n';
import ar from '@/locales/ar.json';
import en from '@/locales/en.json';
import fr from '@/locales/fr.json';

export type SupportedLocale = 'ar' | 'fr' | 'en';

export const SUPPORTED_LOCALES: SupportedLocale[] = ['ar', 'fr', 'en'];

export const FALLBACK_LOCALE: SupportedLocale = 'ar';

/**
 * `numberingSystem: 'latn'` is forced explicitly rather than relying on the
 * `ar-DZ` locale tag's CLDR default (Maghreb Arabic defaults to Western
 * digits, Mashriq Arabic does not) — ICU data completeness varies across
 * browsers/Node builds, so the explicit override is the only version that
 * can't silently regress.
 */
const numberFormats = {
    ar: {
        decimal: { numberingSystem: 'latn' },
        integer: { numberingSystem: 'latn', maximumFractionDigits: 0 },
    },
    fr: {
        decimal: {},
        integer: { maximumFractionDigits: 0 },
    },
    en: {
        decimal: {},
        integer: { maximumFractionDigits: 0 },
    },
};

export function createAppI18n(locale: SupportedLocale) {
    return createI18n({
        legacy: false,
        locale,
        fallbackLocale: FALLBACK_LOCALE,
        messages: { ar, fr, en },
        numberFormats,
    });
}

/**
 * Applies a locale change reactively, client-side, with no page reload.
 *
 * Inertia visits (e.g. clicking a language link) swap the page component via
 * XHR — they never re-run app.blade.php. So `dir`/`lang` on <html>, set by
 * Blade on the very first load, and vue-i18n's active locale, fixed once at
 * app boot, both need to be re-applied by hand after every such navigation
 * or the UI silently keeps rendering the old language until a hard refresh.
 */
export function applyLocale(
    i18n: ReturnType<typeof createAppI18n>,
    locale: SupportedLocale,
): void {
    i18n.global.locale.value = locale;

    const html = document.documentElement;
    html.dir = locale === 'ar' ? 'rtl' : 'ltr';
    html.lang = locale === 'ar' ? 'ar-DZ' : locale;
}
