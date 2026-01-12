---
title: Introduction
slug: index
status: published
---

<div class="badges">

[![Release](https://img.shields.io/github/v/release/ava-cms/ava)](https://github.com/ava-cms/ava/releases)
[![Issues](https://img.shields.io/github/issues/ava-cms/ava)](https://github.com/ava-cms/ava/issues)
[![Code size](https://img.shields.io/github/languages/code-size/ava-cms/ava)](https://github.com/ava-cms/ava)
[![Discord](https://img.shields.io/discord/1028357262189801563)](https://discord.gg/fZwW4jBVh5)
[![GitHub Repo stars](https://img.shields.io/github/stars/ava-cms/ava)](https://github.com/ava-cms/ava)

</div>

A friendly, flexible, flat-file PHP-based CMS for bespoke personal websites, blogs and more.

## Philosophy

Ava is designed for people who love the web. It sits in the sweet spot between a static site generator and a full-blown CMS:

<div class="philosophy-grid">
<div class="philosophy-grid-item">

**📂 Your Files, Your Rules.** Content is just Markdown files with YAML frontmatter, optional HTML, and extensible PHP shortcodes. Configuration is readable PHP. Your files are the source of truth.

</div>
<div class="philosophy-grid-item">

**✍️ Bring Your Own Editor.** No clunky WYSIWYG editors here. Write in your favourite text editor, IDE or even the terminal. If you can write a little HTML and CSS, you can build a theme.

</div>
<div class="philosophy-grid-item">

**🚀 No Database Required.** No database is required, but SQLite is seamlessly available as a lightweight local file to support large content collections while keeping memory usage low.

</div>
<div class="philosophy-grid-item">

**⚡ Edit Live.** Edit a file, refresh your browser, see it live. There's no build step, no deploy queue, and no waiting for static regeneration. Changes are immediate.

</div>
<div class="philosophy-grid-item">

**🎨 Bespoke by Design.** Don't fight a platform. Create any content type you want: blogs, portfolios, recipe collections, changelogs and more without plugins or hacks.

</div>
<div class="philosophy-grid-item">

**🤖 AI Friendly.** The clean file-based structure, thorough integrated documentation and straightforward CLI makes it easy for AI assistants to help you build themes and extensions.

</div>
</div>

## Core Features

| Feature | What it does for you |
|---------|-------------|
| **Content&nbsp;Types** | [Define](/docs/configuration#content-types) exactly what you're publishing (Pages, Posts, Projects, etc.). |
| **Taxonomies** | [Organise](/docs/configuration#taxonomies) content your way with custom categories, tags, or collections. |
| **Smart&nbsp;Routing** | URLs are generated [automatically](/docs/routing) based on your content structure. |
| **Themes** | Write standard HTML and CSS however you prefer, use PHP and Ava's [helpers](/docs/themes) only where you need dynamic data. |
| **Plugins** | Add [functionality](/docs/creating-plugins) like sitemaps and feeds without bloat. |
| **Speed** | Built-in page [caching](/docs/performance) makes your site load instantly, even on cheap hosting. |
| **Search** | Full-text search across your content with [configurable](/docs/configuration#search-configuration) weights. |
| **CLI Tool** | Manage your site from the [command line](/docs/cli): clear caches, create users, run tests, and more. |

## Performance

Ava is designed to be fast by default, whether you have 100 posts or 100,000.

- **Instant Publishing:** No build step. Edit a file, refresh your browser, see it live. There’s no build step, no deploy queue, and no waiting for static regeneration. Changes are immediate.
- **Smart Caching:** A [tiered caching system](/docs/performance) keeps page generation extremely fast. Even without page caching, posts compile quickly, and large content updates can be indexed almost immediately for responsive search and sorting.
- **Scalable Backends:** Start with the default Array backend for raw speed, or switch to [SQLite](/docs/performance#sqlite-backend) for constant memory usage at scale.
- **Static Speed:** Enable [full page caching](/docs/performance#page-caching) to serve static HTML files, bypassing the application entirely for most visitors.

[See full benchmarks and scaling guide →](/docs/performance)

## Command Line Interface

Ava includes a friendly CLI for managing your site. Run commands from your project root to check status, rebuild indexes, create content, and more.

```bash
./ava status
```

<pre><samp><span class="t-cyan">   ▄▄▄  ▄▄ ▄▄  ▄▄▄     ▄▄▄▄ ▄▄   ▄▄  ▄▄▄▄
  ██▀██ ██▄██ ██▀██   ██▀▀▀ ██▀▄▀██ ███▄▄
  ██▀██  ▀█▀  ██▀██   ▀████ ██   ██ ▄▄██▀</span>

  <span class="t-dim">───</span> <span class="t-cyan t-bold">Site</span> <span class="t-dim">──────────────────────────────────────────────</span>

  <span class="t-dim">Name:</span>       <span class="t-white">My Site</span>
  <span class="t-dim">URL:</span>        <span class="t-cyan">https://example.com</span>

  <span class="t-dim">───</span> <span class="t-cyan t-bold">Content</span> <span class="t-dim">───────────────────────────────────────────</span>

  <span class="t-cyan">◆ Page:</span> <span class="t-white">5 published</span>
  <span class="t-cyan">◆ Post:</span> <span class="t-white">38 published</span> <span class="t-yellow">(4 drafts)</span>

  <span class="t-dim">───</span> <span class="t-cyan t-bold">Page Cache</span> <span class="t-dim">────────────────────────────────────────</span>

  <span class="t-dim">Status:</span>     <span class="t-green">● Enabled</span>
  <span class="t-dim">Cached:</span>     <span class="t-white">42 pages</span></samp></pre>

[See full CLI reference →](/docs/cli)

## Admin Dashboard

Ava includes a web-based admin panel for monitoring your site. It's completely optional and everything can be done via the CLI or direct file editing, but it's handy for quick overviews and common tasks.

<a href="@media:admin-dashboard.webp" target="_blank" rel="noopener">
  <img src="@media:admin-dashboard.webp" alt="Ava Admin Dashboard" />
</a>

The dashboard gives you a bird's-eye view of your content, taxonomy terms, and system health. Browse and preview content, view themes, manage redirects, and check logs without touching the command line.

[See admin documentation →](/docs/admin)

## Requirements

<img src="https://addy.zip/ava/i-love-php.webp" alt="I love PHP" style="float: right; width: 180px; margin: 0 0 1rem 1.5rem;" />

Ava requires **PHP 8.3** or later and **SSH access** for some simple commands. Most good hosts include this, but check before you start.

**Required Extensions:**

- `mbstring` — UTF-8 text handling
- `json` — Config and API responses
- `ctype` — String validation

These are bundled with most PHP installations. If you're missing one, your host's control panel or `apt install php-mbstring` will sort it out.

**Optional Extensions:**

- `pdo_sqlite` — SQLite backend for large sites (10k+ items, constant memory)
- `igbinary` — Faster content indexing and smaller cache files
- `opcache` — Opcode caching for production

If `igbinary` isn't available, Ava falls back to PHP's built-in `serialize`. Both work fine, `igbinary` is just [faster](/docs/performance).

## Quick Start

Getting started with Ava is incredibly simple and the default set-up can be put live in just a minute. Here are a few options:

### Download and Upload

The simplest approach—no special tools required:

[![Release](https://img.shields.io/github/v/release/ava-cms/ava)](https://github.com/ava-cms/ava/releases)

1. Download the latest release from [GitHub Releases](https://github.com/ava-cms/ava/releases)
2. Extract the ZIP file
3. Upload to your web host (via SFTP, your host's file manager, or however you prefer)
4. Run `composer install` to install dependencies
5. [Configure](/docs/configuration) your site by editing `app/config/ava.php`
6. Visit your site!

### Clone with Git

If you're comfortable with Git and want version control from the start:

1. Clone the repo in your websites root directory (above the `public` folder):
```bash
git clone https://github.com/ava-cms/ava.git
```
2. Install dependencies:
```bash
composer install
```
3. [Configure](/docs/configuration) your site by editing `app/config/ava.php`
4. Visit your site!

### Local Development (Optional)

If you want to preview your site on your own computer before going live:

```bash
php -S localhost:8000 -t public
```

Then visit [http://localhost:8000](http://localhost:8000) in your browser.

<details class="beginner-box">
<summary>Ready for Production?</summary>
<div class="beginner-box-content">

### Ready for Production?

See the [Hosting Guide](/docs/hosting) for shared hosting, VPS options, and deployment tips.

</div>
</details>

### Default Site

By default, Ava comes with a simple example site. You can replace the content in the `content/` folder and your theme in the `themes/default/` folder to start building your site.

<img src="@media:default.webp" alt="Default theme preview" />

The default theme provides a clean, minimal starting point for your site. Customise it with your own styles, scripts and templates to match your vibe or [build something entirely new](/docs/themes).

## Project Structure

<pre><code class="language-text">mysite/
├── app/
│   └── config/          # Configuration files
│       ├── ava.php      # Main config (site, paths, caching)
│       ├── content_types.php
│       └── taxonomies.php
├── content/
│   ├── pages/           # Page content (hierarchical URLs)
│   ├── posts/           # Blog posts (/blog/{slug})
│   └── _taxonomies/     # Term registries
├── themes/
│   └── default/         # Theme templates
│       ├── templates/
│       └── assets/
├── plugins/             # Optional plugins
├── snippets/            # Safe PHP snippets for &#91;snippet&#93; shortcode
├── public/              # Web root
│   ├── media/           # @media<span></span>: downloads referenced via @media<span></span>: alias
│   └── index.php        # Entry point
├── storage/cache/       # Content index and page cache (gitignored)
└── ava                  # CLI tool
</code></pre>

## How It Works

1. **[Write](/docs/content)** — Create Markdown files in your `content/` folder.
2. **[Index](/docs/performance)** — Ava automatically scans your files and builds a fast index.
3. **[Render](/docs/themes)** — Your theme turns that content into beautiful HTML.

The system handles all the boring stuff: routing, sorting, pagination, and search. You just focus on the content and the design.

## Editing Content: Pick Your Style

Ava is flexible about *how* you work. There's no "correct" way to edit—pick whatever fits your workflow:

- **Edit directly on your server** — SFTP, SSH, or your host's file manager. Changes appear instantly.
- **Work locally** — Edit on your computer and upload when ready. Great for bigger changes.
- **Use Git** — Version control with GitHub, GitLab, etc. Perfect for collaboration and history.
- **Mix and match** — Quick fixes on the server, bigger projects locally. Whatever works for you.

If you want some beginner-friendly background on the tools involved:

- Learn the basics of running commands in [CLI](/docs/cli)
- Learn what Markdown is (and what editors are great) in [Content](/docs/content)

## Is Ava for You?

Ava is perfect if:
- You know some HTML and CSS (or want to learn!).
- You prefer writing in a real text editor over a web form.
- You want a fast, personal site that you fully own and control.
- You don't want to deal with deployment processes or build steps.
- You don't want to manage a database or complex server setup, just files.

It won't be a good fit if you need a drag-and-drop page builder or a massive ecosystem of third-party themes.

## Next Steps

- [Configuration](/docs/configuration) — Site settings and content types
- [Content](/docs/content) — Writing pages and posts
- [Hosting](/docs/hosting) — Getting your site live
- [Themes](/docs/themes) — Creating templates
- [Admin](/docs/admin) — Optional dashboard
- [CLI](/docs/cli) — Command-line tools
- [Showcase](/showcase) — Community sites, themes, and plugins

## License

Ava CMS is free and open-source software licensed under the [MIT License](https://github.com/ava-cms/ava/blob/main/LICENSE).

In plain English, that means you can:

- Use Ava for personal or commercial projects.
- Modify it to fit your site (and keep your changes private if you want).
- Share it, fork it, and redistribute it.

The main thing the license asks is that you keep the MIT license text and copyright notice with the software.

Also worth knowing: the MIT license comes with a standard “no warranty” clause. Ava is provided as-is, so you’re responsible for how you deploy and run it. There's no guarantees that it's fit-for-purpose or impenetrably secure. Standard open-source stuff.

## Contributing

Ava is still fairly early and moving quickly, so I’m not looking for undiscussed pull requests or additional contributors just yet.

That said, I’d genuinely love your feedback:

- If you run into a bug, get stuck, or have a “this could be nicer” moment, please [open an issue](https://github.com/ava-cms/ava/issues).
- Feature requests, ideas, and “what if Ava could…” suggestions are very welcome.

If you prefer a more conversational place to ask questions and share ideas, join the [Discord community](https://discord.gg/fZwW4jBVh5).

Even small notes help a lot at this stage.

## Community

See what others are building with Ava:

- [Community Plugins](/plugins) — Extend Ava with plugins shared by the community
- [Community Themes](/themes) — Ready-to-use themes for your site
- [Sites Built with Ava](/showcase) — Get inspired by what others have created