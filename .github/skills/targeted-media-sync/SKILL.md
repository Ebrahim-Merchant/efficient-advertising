---
name: targeted-media-sync
description: Sync only the missing uploads needed by the live Wasmer site instead of bulk-copying the entire media library.
---

# Targeted media sync

Use this skill when images are missing on the live site but full uploads copies would be too slow or too large.

## Do this

1. Identify missing files from rendered pages or DB references.
2. Build a minimal manifest of only the missing paths.
3. Upload in small batches.
4. Recheck the same pages or paths after each batch.

## Repo-specific note

Small batches worked reliably here; large one-shot uploads timed out at Wasmer edge.
