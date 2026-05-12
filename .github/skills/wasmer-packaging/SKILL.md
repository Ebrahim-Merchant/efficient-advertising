---
name: wasmer-packaging
description: Rebuild and validate the Wasmer package layout for this WordPress repository before any deploy.
---

# Wasmer packaging

Use this skill when the task involves preparing or checking a Wasmer deploy for this repo.

## Do this

1. Run `bash scripts/sync-wasmer-app.sh`.
2. Confirm the staged app contains:
   - `app/index.php`
   - `app/wp-config.php`
   - `app/wp-admin/`
   - `app/wp-includes/`
   - `app/wp-content/themes/`
   - `app/wp-content/plugins/`
3. Review `app.yaml`, `wasmer.toml`, `config/php.ini`, and `wp-config.wasmer.php`.
4. Treat `app/` as generated output and never edit it directly.

## Repo-specific note

This repo deploys a generated `/app` layout, not the raw repository tree.
