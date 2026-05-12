---
name: edge-publication-triage
description: Diagnose Wasmer cases where the control plane advances but the public edge still serves an older runtime.
---

# Wasmer edge publication triage

Use this skill when Wasmer says a deploy succeeded but the public site still looks old or broken.

## Do this

1. Compare Wasmer app/version metadata with the public site headers.
2. Check `x-edge-app-version-id` on the public response.
3. Verify `/`, `/wp-login.php`, and a representative content URL on the public domain.
4. If Wasmer metadata changed but the public edge did not, report it as an edge-publication mismatch.

## Repo-specific note

This exact repo already had a persistent `v1` edge runtime even after newer versions were marked active in Wasmer.
