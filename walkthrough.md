# Walkthrough: Dynamic Registration with Algerian Communes, Wilayas & Geo Rules

## Overview
We have completed the schema realignment with [`countries.json`](file:///C:/Herd/test-project/public/assets/seeders/countries.json), updated [`CommuneSeeder.php`](file:///C:/Herd/test-project/database/seeders/CommuneSeeder.php) and [`CountrySeeder.php`](file:///C:/Herd/test-project/database/seeders/CountrySeeder.php), and delivered an animated, spacious, bilingual registration form.

---

## 1. Database & Seeder Enhancements
- **Complete `countries.json` Schema Integration, Phone Codes & National Flags:**
  - Migrated `countries` table with all attributes: `id`, `ulid`, `name`, `native_name`, `arabic_name`, `nationality`, `nationality_ar`, `nationality_en`, `alpha2`, `alpha3`, `numeric_code`, `currency_code`, `phone_code`, `flag_url`, `is_active`, `is_visible`, `timestamps`, and `softDeletes`.
  - Updated [`countries.json`](file:///C:/Herd/test-project/public/assets/seeders/countries.json) and [`CountrySeeder.php`](file:///C:/Herd/test-project/database/seeders/CountrySeeder.php) to populate **100% of international dialing codes** and **national flag SVG URLs** (`flag_url`) for all **99 countries**.
  - Seeded **1,828 official Algerian communes** and **69 Wilayas** via [`CommuneSeeder.php`](file:///C:/Herd/test-project/database/seeders/CommuneSeeder.php) from [`algeria_cities.json`](file:///C:/Herd/test-project/public/assets/seeders/algeria_cities.json).
- **Extended User Schema & Fortify Actions:**
  - Added migration [`2026_08_24_143444_add_extended_fields_to_users_table.php`](file:///C:/Herd/test-project/database/migrations/2026_08_24_143444_add_extended_fields_to_users_table.php) supporting `first_name_ar`, `last_name_ar`, `country_id`, `wilaya_id`, `commune_id`, and `city`.
  - Updated [`CreateNewUser.php`](file:///C:/Herd/test-project/app/Actions/Fortify/CreateNewUser.php) with strict validation, Arabic regex checks, and conditional Wilaya/Commune rules.

---

## 2. Dynamic Registration Form Architecture
Implemented in [`Register.vue`](file:///C:/Herd/test-project/resources/js/pages/auth/Register.vue) & [`SearchableSelect.vue`](file:///C:/Herd/test-project/resources/js/components/ui/SearchableSelect.vue):

1. **Embedded Real-Time Search Inside Select Dropdowns (`SearchableSelect`):**
   - **Integrated Search Header:** Floating glassmorphic popover with auto-focus search bar and clear button (`X`).
   - **Multi-Field Filtering:** Search in real-time by French name, Arabic name, ISO code, or phone dialing code (e.g. typing "213", "Fra", "وهران", "16", "Alger").
   - **Accessibility & Keyboard Navigation:** Supports `ArrowDown`, `ArrowUp`, `Enter` to select, and `Escape` to close.
   - **Form Sync:** Seamless synchronization with native hidden inputs `<input type="hidden" :name="name" :value="modelValue" />` for Inertia `<Form>` submissions.
2. **Animated Glowing Borders & Focus Effects:**
   - Engineered `.input-premium` and `.input-premium-teal` with smooth `300ms ease-out` transitions.
   - **Hover state:** Subtle illumination ring (`rgba(27, 102, 157, 0.16)`).
   - **Focus state:** Vibrant outer glow with deep ring shadow (`box-shadow: 0 0 0 4px rgba(27, 102, 157, 0.18), 0 0 20px -2px rgba(27, 102, 157, 0.3)`) and subtle `-1px` vertical elevation.
   - **Arabic fields:** Styled with ONDA Emerald Teal glowing accents (`#1C9976`).
3. **Generous Card Spacing & Proportions ("Espace"):**
   - Expanded card container width to `max-w-[560px]` on desktop with generous `p-8 sm:p-10 lg:p-11` padding.
   - Increased inter-field spacing to `gap-5` and `space-y-4.5` for balanced visual breathing room.
4. **Bilingual Dual-Script Names & Strict Directional Alignments:**
   - **Latin Inputs (`first_name`, `last_name`):** Always enforced **LTR (`dir="ltr" text-left`)**, even when page is in Arabic RTL mode.
   - **Arabic Inputs (`first_name_ar`, `last_name_ar`):** Always enforced **RTL (`dir="rtl" text-right font-arabic`)** with real-time regex filtering `[\u0600-\u06FF\s]`.
   - **Email Address (`email`):** Always enforced **LTR (`dir="ltr" text-left`)**.
   - **Phone Number (`phone`):** Enforced **LTR (`dir="ltr" text-left font-mono`)** with the country dialing prefix badge locked to the left, and **automatic 2-digit spacing** (e.g. `05 49 02 04 55`).
   - **Passwords (`password`, `password_confirmation`):** Enforced **LTR (`dir="ltr" text-left font-mono")**.
6. **Forgot Password, Reset Password & Confirm Password Pages (`ForgotPassword.vue`, `ResetPassword.vue`, `ConfirmPassword.vue`):**
   - **Full Multilingual Translations:** Complete translations in French, Arabic (RTL), and English across headers, descriptions, labels, button labels, Passkey options, and loading states.
   - **Always-LTR Inputs:** Password fields and tokens are locked to **`dir="ltr" text-left font-mono`** even in Arabic mode with glowing `.input-premium` focus borders.
   - **Animated Submit Loading Buttons:** Gradient submit buttons displaying real-time `<Spinner />` animation and localized text during form processing.
   - **Passkey Confirmation Support:** Localized passkey authentication button, separators, and loading feedback.
7. **Email Verification Page & Corporate Dark Slate Mail Design System:**
   - **Interactive Web Page (`VerifyEmail.vue`):**
     - Animated pulse illustration with glassmorphic badge and success checkmark.
     - Multilingual translations (FR, AR RTL, EN) with 3 feature cards (Legal Protection, Digital Filings, Sovereign Cloud).
     - Glowing action buttons with real-time `<Spinner />` animation and spam folder assistance.
   - **Corporate Dark Slate Email Architecture (`resources/views/mail/corporate.blade.php`):**
     - **Email Client Compatibility:** 100% nested table architecture (`<table role="presentation">`) with inline CSS and conditional Microsoft Outlook VML markup (`<!--[if (gte mso 9)|(IE)]>`) for bulletproof rendering across Desktop Outlook, Gmail, Apple Mail, and mobile clients.
     - **Dark Charcoal / Slate Palette:** Slate-950 canvas (`#0b0f19`), Slate-900 inner card (`#111827`), Slate-800 borders (`#1e293b` / `#334155`), and high-contrast typography (`#ffffff` / `#cbd5e1`).
     - **Bilingual Institutional Header:** Features the ONDA monogram badge with gradient background (`#1B669D` to `#1C9976`) and dual Arabic/French institutional subtitles.
     - **Interactive Feature Cards:** 3 structured feature cards (🛡️ *Immediate Legal Protection*, 📜 *Digital Certificates*, 🔒 *Sovereign Encrypted Cloud*).
     - **Bulletproof Primary CTA Button:** Royal Blue `#1d4ed8` button with rounded corners and MSO VML fallback.
     - **Safety / Security Notification Callout:** High-visibility alert card with orange accent border (`#f97316`).
     - **Sovereign Algerian Footer:** Official state credentials and legal disclaimers.
     - **Live Template Preview:** Test and preview live at `http://127.0.0.1:8000/mail/preview`.

8. **App-Wide Fullscreen ONDA Logo & Orbital Preloader (`FullscreenPreloader.vue`):**
   - **Unified Layout Integration:** Embedded across all 3 root layouts:
     1. [`PublicLayout.vue`](file:///C:/Herd/test-project/resources/js/layouts/PublicLayout.vue): Renders for the **Home** page and all public portal views.
     2. [`AuthLayout.vue`](file:///C:/Herd/test-project/resources/js/layouts/AuthLayout.vue): Renders for **Login**, **Register**, **Forgot Password**, **Reset Password**, **Verify Email**, **Two-Factor Challenge**, and **Confirm Password** pages.
     3. [`AppLayout.vue`](file:///C:/Herd/test-project/resources/js/layouts/AppLayout.vue): Renders for **Dashboard**, **Profile**, **Security**, and **Appearance Settings**.
   - **Automatic Request-Driven Loading:** Powered by [`useGlobalLoader.ts`](file:///C:/Herd/test-project/resources/js/composables/useGlobalLoader.ts) listening to Inertia router request lifecycle events (`router.on('start')`, `router.on('finish')`, `router.on('progress')`, `router.on('cancel')`). Whenever a form is submitted (e.g. registration, login, password reset, profile update) or an asynchronous request is dispatched, the fullscreen ONDA orbital loading screen displays dynamically and smoothly dissolves when completed.
   - **Visual Elements:** High-resolution ONDA logo shield with light shimmer sweep, dual-layered conic & dashed orbital spinner rings, ambient radial glows, and official Arabic/French institutional subtitles.
   - **Luminous Progress Bar:** Cubic-eased progress indicator ($0\% \rightarrow 100\%$) with live percentage counter and localized loading text (*« Traitement sécurisé de votre demande... »* / *« جاري معالجة طلبكم بأمان... »*).
   - **Smooth Dissolve Transition:** Dissolves seamlessly via a scale-up fade effect while restoring body scrolling upon completion.

---

## 3. Visual Verification & Browser Testing
- **Fix Applied:** Restored `@inertiajs/vue3` `createInertiaApp` and `router` imports in [`app.ts`](file:///C:/Herd/test-project/resources/js/app.ts), plus fortified DOM teleport safety in [`FullscreenPreloader.vue`](file:///C:/Herd/test-project/resources/js/components/public/FullscreenPreloader.vue).
- Verified that the Home page, Login page, Register page, and all auth pages display the fullscreen ONDA orbital loading screen on initial mount and during form submissions/requests, then dissolve into the page.

````carousel
![Home Page Verified](file:///C:/Users/MOHAMEDADDABENKOSSEI/.gemini/antigravity-ide/brain/86e2dfe1-4731-4115-8c74-a56222c8d77b/home_page_initial_1787774258688.png)
<!-- slide -->
![Login Page Verified](file:///C:/Users/MOHAMEDADDABENKOSSEI/.gemini/antigravity-ide/brain/86e2dfe1-4731-4115-8c74-a56222c8d77b/login_page_loaded_1787774276438.png)
<!-- slide -->
![Input Focus Animated Glow](file:///C:/Users/MOHAMEDADDABENKOSSEI/.gemini/antigravity-ide/brain/86e2dfe1-4731-4115-8c74-a56222c8d77b/fr_focused_input_1787583985657.png)
<!-- slide -->
![Arabic Dynamic Registration with Generous Spacing](file:///C:/Users/MOHAMEDADDABENKOSSEI/.gemini/antigravity-ide/brain/86e2dfe1-4731-4115-8c74-a56222c8d77b/arabic_full_page_1787584104975.png)
<!-- slide -->
![French Registration with Algeria Default (Wilaya & Commune Active)](file:///C:/Users/MOHAMEDADDABENKOSSEI/.gemini/antigravity-ide/brain/86e2dfe1-4731-4115-8c74-a56222c8d77b/register_french_1787583029630.png)
<!-- slide -->
![Foreign Country Selection (France +33 with Free City Input)](file:///C:/Users/MOHAMEDADDABENKOSSEI/.gemini/antigravity-ide/brain/86e2dfe1-4731-4115-8c74-a56222c8d77b/register_foreign_state_1787583084829.png)
````
