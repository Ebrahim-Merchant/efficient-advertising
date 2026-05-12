---
name: plugin-recovery
description: Restore missing plugin and mu-plugin code into the live Wasmer WordPress runtime.
---

# Plugin recovery

Use this skill when WordPress shows `plugin file does not exist`, products stop rendering, or the DB lists active plugins that are missing on disk.

## Do this

1. Compare `active_plugins` with files under `wp-content/plugins`.
2. Compare local `wp-content/mu-plugins` with the live runtime.
3. Restore only the missing plugin code.
4. Reactivate plugins after the files exist.
5. Restore the intended theme when the repair is done.

## Repo-specific note

For this repo, a temporary theme-based importer was the reliable way to repair live plugin files.
