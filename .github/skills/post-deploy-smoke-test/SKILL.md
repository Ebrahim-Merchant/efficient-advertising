---
name: post-deploy-smoke-test
description: Run a minimal public smoke test for the Wasmer-hosted WordPress site after deploys or runtime repairs.
---

# Post-deploy smoke test

Use this skill after deploys, DB imports, plugin restores, or media repairs.

## Check at minimum

1. `https://efficient-advt.wasmer.app/`
2. `https://efficient-advt.wasmer.app/wp-login.php`
3. A representative product URL
4. A representative non-product content page

## Verify

- HTTP 200 responses
- expected page titles or key content
- no obvious missing hero/product images
- no blank page or redirect loop
