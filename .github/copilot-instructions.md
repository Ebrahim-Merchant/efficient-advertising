# Efficient Advertising WordPress + Wasmer

## Repository shape

- This is a full WordPress repository rooted at the project root.
- `app/` is a generated Wasmer staging directory created by `bash scripts/sync-wasmer-app.sh`.
- Never edit `app/` directly. Change source files in the repository, then rebuild `app/`.
- `wp-config.php` is the local LocalWP config. Wasmer packaging uses `wp-config.wasmer.php`.
- `wp-content/uploads/` is runtime content and is intentionally excluded from Git.

## Wasmer deployment files

- `app.yaml` defines the Wasmer app object, capabilities, volumes, and redirect behavior.
- `wasmer.toml` defines the package layout and runtime.
- `config/php.ini` contains Wasmer PHP runtime overrides.
- `scripts/sync-wasmer-app.sh` stages the deployable `/app` layout.
- `wp-config.wasmer.php` is the Wasmer-safe WordPress config that reads environment variables.

## Deployment workflow

- Always rebuild the staged app with `bash scripts/sync-wasmer-app.sh` before validating or deploying.
- Validate that `app/wp-config.php`, `app/wp-admin/`, `app/wp-includes/`, and `app/wp-content/plugins/` exist after staging.
- The target live app is `ebrahim-merchant/efficient-advt` at `https://efficient-advt.wasmer.app`.
- Do not declare a deploy successful based only on Wasmer metadata. Check the public site too.

## Known Wasmer production caveat

- This project has already hit a Wasmer control-plane versus edge-publication mismatch:
  - Wasmer metadata advanced to newer versions.
  - The public edge kept serving the old `v1`.
- Always compare public response headers such as `x-edge-app-version-id` with the version Wasmer says is active.
- If the public edge still serves the old runtime, repair the live DB and `wp-content` volume used by that runtime instead of assuming the new deploy is live.

## Live-runtime repair patterns that worked

- Theme uploads through wp-admin worked reliably on the live runtime.
- Large one-shot uploads timed out. Smaller theme-upload batches were reliable.
- A temporary theme-based importer worked for copying files into:
  - `wp-content/uploads`
  - `wp-content/plugins`
  - `wp-content/mu-plugins`
- After any importer run, restore the active theme to `NewEfficientAdvtWorkingTheme_v1.0`.

## Database and WooCommerce notes

- MySQL CLI access may fail even when PHP or mysqli access works.
- For full imports, prefer standalone PHP or WordPress/PHP DB access when MySQL CLI is blocked.
- After DB imports:
  - rewrite local URLs to `https://efficient-advt.wasmer.app`
  - update `home` and `siteurl`
  - flush rewrites
- WooCommerce product data can exist in the DB while the site still fails to render products if the WooCommerce plugin code is missing from the served runtime.
- Product image coverage is best derived from `_thumbnail_id`, `_product_image_gallery`, and `_wp_attachment_metadata`.

## Media sync rules

- Prefer targeted syncs over full uploads-volume copies.
- Use browser diffs or DB-derived file paths to identify only the missing files.
- Keep upload batches small enough to avoid Wasmer edge timeouts; around 40 MB per batch worked reliably here.
- If only the original image exists locally but WordPress expects size variants, generate the missing variants and upload them too.

## Git and publishing safety

- Never commit local secrets or machine-specific files such as:
  - `wp-config.php`
  - SQL dumps
  - backup archives
  - generated `app/`
  - `wp-content/uploads/`
- Preserve user changes outside the current task.
- When replacing published GitHub history, preserve the old remote content on a backup branch first.
