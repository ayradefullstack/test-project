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
6. **Forgot Password & Reset Password Pages (`ForgotPassword.vue` & `ResetPassword.vue`):**
   - **Full Multilingual Translations:** Complete translations in French, Arabic (RTL), and English across headers, descriptions, labels, button labels, and loading states.
   - **Always-LTR Inputs:** Email, passwords, and tokens are locked to **`dir="ltr" text-left`** even in Arabic mode.
   - **Glowing Animated Inputs:** Styled with `.input-premium` animated borders and focus illumination rings.
   - **Animated Submit Loading Button:** Gradient submit button displaying real-time `<Spinner />` animation and localized text (`Sending reset link...` / `جاري إرسال الرابط...` / `Envoi du lien en cours...`) during form processing.
   - **Seamless Navigation:** Returns to login preserving the active locale.

---

## 3. Visual Verification

````carousel
![Input Focus Animated Glow](file:///C:/Users/MOHAMEDADDABENKOSSEI/.gemini/antigravity-ide/brain/86e2dfe1-4731-4115-8c74-a56222c8d77b/fr_focused_input_1787583985657.png)
<!-- slide -->
![Arabic Dynamic Registration with Generous Spacing](file:///C:/Users/MOHAMEDADDABENKOSSEI/.gemini/antigravity-ide/brain/86e2dfe1-4731-4115-8c74-a56222c8d77b/arabic_full_page_1787584104975.png)
<!-- slide -->
![French Registration with Algeria Default (Wilaya & Commune Active)](file:///C:/Users/MOHAMEDADDABENKOSSEI/.gemini/antigravity-ide/brain/86e2dfe1-4731-4115-8c74-a56222c8d77b/register_french_1787583029630.png)
<!-- slide -->
![Foreign Country Selection (France +33 with Free City Input)](file:///C:/Users/MOHAMEDADDABENKOSSEI/.gemini/antigravity-ide/brain/86e2dfe1-4731-4115-8c74-a56222c8d77b/register_foreign_state_1787583084829.png)
````
