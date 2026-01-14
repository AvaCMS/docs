---
title: Changelog (Docs Team)
slug: changelog
status: published
---

This page summarizes recent core and bundled-plugin changes that the docs team should be aware of and reflect in the user-facing documentation.

## 2026-01-13 — Core & Plugins

### Core Framework

- `core/Application.php`
  - `loadPlugins()` is now `public` (was `private`). This allows the CLI and other external contexts to trigger plugin loading and hook registration explicitly.
  - The CLI ensures `loadPlugins()` is called before running a `rebuild` so plugin hooks are registered for CLI-invoked rebuilds.

- `core/Indexer.php`
  - New hook: `indexer.rebuild`
  - Fires at the end of `Indexer::rebuild()` whenever the content index is rebuilt (CLI, automatic on boot, or via the admin panel).
  - Passes the `\Ava\Application` instance as an argument.
  - Note: Use `indexer.rebuild` for content-syncing plugins; it is more reliable than `cli.rebuild` because it captures all rebuild contexts.

### CLI

- `cli.rebuild` remains available for CLI-specific post-processing tasks and console-only actions. Plugins printing console messages should guard output with `php_sapi_name() === 'cli'`.

### Bundled: Sitemap Plugin

- `plugins/sitemap/plugin.php`
  - The plugin now listens to `indexer.rebuild` so it runs for all rebuild contexts (CLI, auto, admin).
  - Status/console messages are emitted only when running in CLI mode (`php_sapi_name() === 'cli'`) to avoid polluting web responses.
  - On every content index rebuild, the plugin:
    - Checks `public/robots.txt` and creates it if missing (with sensible defaults).
    - Adds or updates the `Sitemap: <url>` line to match the configured `site.base_url`.
    - Preserves existing `User-agent` and `Allow` rules when updating the file.

---

If you need a short blurb or release note for the public changelog (less technical), tell me and I can prepare it.