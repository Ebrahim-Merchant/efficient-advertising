# Codebase Rules (One Page)

These rules apply to all work in this repository and are mandatory for every change.

## 1) Scope and Source of Truth
- This is a WordPress + WooCommerce LocalWP project; runtime code root is `app/public`.
- Active theme for all new work: `wp-content/themes/NewEfficientAdvtWorkingTheme_v1.0`.
- `wp-content/themes/Efficient` and `wp-content/themes/Efficient-dev` are reference/legacy only unless explicitly reactivated.
- Custom behavior must live in the active theme, `wp-content/mu-plugins`, or dedicated custom plugins.

## 2) What Must Not Be Edited
- Do not edit WordPress core (`wp-admin`, `wp-includes`) directly.
- Do not edit third-party plugin vendor code directly unless there is no alternative and the change is documented.
- Do not keep working backup files in active runtime paths (`.bak`, `.OLD`, `.disabled`, `copy`, timestamped duplicates).

## 3) File and Folder Hygiene
- Move one-off scripts and experiments out of web root into a controlled tools area (`app/public/tools` or repo-level tools folder).
- Keep all project documentation in markdown files with clear names and dates.
- Use append-only status logs for progress tracking; do not rewrite historical entries.
- Keep generated exports (CSV/JSON/XLSX) grouped in clearly named folders.

## 4) Coding Standards
- Follow WordPress coding conventions for PHP and hooks.
- Prefer small, named functions over long inline anonymous blocks when logic is reused.
- Sanitize, escape, and validate all external input/output (`sanitize_*`, `esc_*`, nonces, capability checks).
- Keep templates focused on rendering; move business logic into `inc/` or plugin functions.
- Preserve existing taxonomy conventions (`product_cat`) and avoid introducing parallel taxonomies without approval.

## 5) Performance Rules
- Product/category archives must stay paginated (no unbounded product queries in templates).
- Use lazy-loading for non-critical media; preload only truly critical hero/LCP assets.
- Avoid heavy repeated DB queries in header/menu/template loops; cache or curate where possible.
- Any change affecting category/product templates must include a quick performance sanity check.

## 6) SEO and Content Quality Gate
- Exactly one H1 per page.
- Every published product requires: unique intro/description, featured image, meaningful alt text, correct category.
- Titles/meta descriptions must be present (Yoast or fallback logic).
- No placeholder text/images on production-facing templates.

## 7) UX and Conversion Rules
- Preserve catalog-mode intent: quote/WhatsApp/contact CTAs are primary.
- Keep mobile CTA behavior clean (no duplicate floating chat/CTA collisions).
- Maintain consistent premium visual system (typography, spacing, color tokens) across templates.
- Validate key pages after changes: homepage, one category, one product, contact page.

## 8) Security and Config
- Never commit secrets, API keys, credentials, or local-only sensitive config values.
- Keep `DISALLOW_FILE_EDIT` enabled in WordPress config for non-dev environments.
- Any admin/AJAX action must enforce nonce + capability checks.
- Restrict destructive tools/actions to authorized admin users only.

## 9) Change Management
- One ticket/task = one focused change set.
- Document purpose, files changed, and rollback path for non-trivial updates.
- Before handoff: run PHP lint on touched PHP files and perform basic page smoke tests.
- Definition of Done: code passes syntax checks, UX checked desktop/mobile, CTAs/links work, no critical console/PHP errors.

## 10) Release Rule
- If a change degrades speed, breaks content quality, or introduces duplicate UX elements, it does not ship.
