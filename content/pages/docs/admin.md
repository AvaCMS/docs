---
title: Admin Dashboard
status: published
meta_title: Admin Dashboard | Flat-file PHP CMS | Ava CMS
meta_description: Optional admin dashboard for Ava. Create users, make quick content edits, manage taxonomies, and monitor system health.
---

Ava includes an optional admin dashboard to help you monitor your site and make quick changes when you’re away from your normal workflow.

It’s intentionally not a “database CMS”: your Markdown files remain the source of truth. The admin gives you a safe, convenient way to do things like quick edits, rebuild the index, review logs, and manage taxonomy terms.

<a href="@media:admin-dashboard.webp" target="_blank" rel="noopener">
    <img src="@media:admin-dashboard.webp" alt="Ava admin dashboard" />
</a>

## What's it for?

Think of the dashboard as a friendly window into your site's engine room:

- **✍️ Quick edits / authoring on the go** — Edit Markdown + frontmatter in a built-in file editor.
- **📚 Browse content** — See what content exists, its status, and where it lives on disk.
- **🧹 Linting** — Check content for frontmatter and indexing issues.
- **⚡ Maintenance** — Rebuild the index and clear cached pages.
- **🏷️ Taxonomy management** — Create/delete terms via a file-backed term registry.
- **🖼️ Media uploads** — Upload images to your media folder (optional).
- **🧾 Logs & diagnostics** — View admin logs and system information.
- **🧩 Shortcodes** — See which shortcodes are available.

In practice, that means:

- **Content**: browse by type, create/edit/delete Markdown files, generate frontmatter, preview drafts (with a preview token).
- **Validation**: run the content linter (frontmatter validity, duplicate content keys, duplicate IDs).
- **Maintenance**: rebuild the content index, flush cached pages.
- **Taxonomies**: view term counts, create/delete terms via a file-backed registry.
- **Media** (optional): upload images to your media folder.

### Content safety checks

When saving content via the admin editor, Ava blocks some high-risk HTML and URL patterns (for example `<script>`, `<iframe>`, `on*=` event handlers, and `javascript:` URLs). If you need advanced HTML, edit the file directly on disk.

<div class="callout-info">
For <strong>hierarchical</strong> content types, the public URL is derived from the file path (and <code>index.md</code>/<code>_index.md</code> conventions). The <code>slug:</code> frontmatter field is still validated and used as metadata, but it does not control the URL for hierarchical content.
</div>

### Taxonomies (file-backed)

If you define taxonomies in `app/config/taxonomies.php`, the admin can manage a term registry stored in:

- `content/_taxonomies/{taxonomy}.yml`

The file format is a YAML list:

```yaml
- slug: tutorials
    name: Tutorials
    description: Tutorials and guides

- slug: php
    name: PHP
```

Deleting a term in the admin removes it from the registry file, but does not rewrite your content files.

## Enabling the Dashboard

It's disabled by default. To turn it on, edit `app/config/ava.php`:

```php
'admin' => [
    'enabled' => true,
    'path' => '/admin',
],
```

You can change `path` to move the admin URL (for example, `/dashboard`).

## Creating Your First User

Since there's no database, users are stored in a config file. Use the CLI to create one:

```bash
./ava user:add admin@example.com yourpassword "Your Name"
```

This creates a secure `app/config/users.php` file. If you're using version control, this file is gitignored by default to keep your credentials safe.

[Read more about security below](admin?id=security).

### No SSH? (Manual user creation)

The recommended way to add users is still the CLI, but if your host doesn’t provide SSH, you can create/update `app/config/users.php` using your host’s file manager or SFTP.

Two practical options:

- **Run the CLI locally, then upload `users.php`.** Clone your site repo locally, run `./ava user:add ...`, then upload the resulting `app/config/users.php` to the server.
- **Edit `users.php` directly (not ideal, but works).** Add a new array entry for the user email.

`app/config/users.php` looks like this:

```php
<?php

declare(strict_types=1);

return [
    'admin@example.com' => [
        'password' => '$2y$12$REPLACE_WITH_A_BCRYPT_HASH',
        'name' => 'Admin',
        'created' => '2026-01-12',
    ],
];
```

To generate the bcrypt password hash on your own machine (where you can run PHP), use:

```bash
php -r 'echo password_hash("your-password-here", PASSWORD_BCRYPT, ["cost" => 12]), PHP_EOL;'
```

Copy the output into the `password` field. Ava stores only the hash.

<div class="callout-warning">
<strong>Important:</strong> the password must be at least 8 characters (the same rule as <code>./ava user:add</code>). After the first successful login, Ava may add fields like <code>last_login</code> to this file automatically.
</div>

## Security

The admin dashboard is designed with security as a priority. Here's exactly how your credentials and sessions are protected:

### Password Storage

When you create a user with `./ava user:add`, your password goes through these steps:

1. **Hashing with bcrypt** - Uses PHP's `password_hash()` with bcrypt and a cost factor of 12 (current security recommendation)
2. **Only the hash is stored** - Your actual password never touches the disk; only the irreversible hash is saved to `app/config/users.php`
3. **Future-proof** - Uses `PASSWORD_BCRYPT` explicitly, ensuring consistent behaviour across PHP versions

**What this means for you:** If someone gains access to your `users.php` file, they get your **password hash**, not your plain-text password. 

<div class="callout-warning"><strong>Always use a strong, long password.</strong> A bcrypt hash is designed to be expensive to brute-force, but it is not magic — <strong>if your password is weak</strong> (or an attacker has enough time and compute), <strong>it could still be guessed</strong>.</div>

**Treat `app/config/users.php` as sensitive:**
- Keep it private (server permissions / backups / hosting control panel access)
- Never commit it to a public repository
- If it’s ever leaked, rotate passwords immediately (use `./ava user:password <email> <new-password>`)

Example of what's stored (the password is not stored, but the hash can be attacked with password guessing):
```php
'password' => '$2a$12$erDlkVmb.CvQbJeQoAkwoej1FANMw2QTzf3h2/VI5acJYHcpPagJa'
```

<details class="beginner-box">
<summary>What is bcrypt?</summary>
<div class="beginner-box-content">

### What is bcrypt?

**Understanding the hash:**
- `$2a$` = Bcrypt algorithm identifier
- `12$` = Cost factor (2^12 = 4,096 iterations)
- `erDlkVmb.CvQbJeQoAkwoe` = The **salt** (22 characters, randomly generated)
- `j1FANMw2QTzf3h2/VI5acJYHcpPagJa` = The actual hash of (password + salt)

**Why bcrypt is safer from brute-force and rainbow tables (unlike MD5):**

Rainbow tables are pre-computed databases of password hashes. With MD5, if your password is "password123", the hash is always `482c811da5d5b4bc6d497ffa98491e38`. An attacker can look this up instantly in a rainbow table.

Bcrypt prevents this with **automatic salting**:

1. **Each hash gets a unique random salt** - Even if two users have the same password, their hashes look completely different because the salt is different
2. **Salt is stored in the hash itself** - The 22 characters after `$12$` are the salt, stored right in the hash so PHP can verify passwords later
3. **Salt makes rainbow tables practically useless** - A rainbow table would need a separate entry for every possible password × every possible salt combination (astronomically large)
4. **Slow by design** - Cost factor of 12 means 4,096 iterations, making brute-force attacks take much longer (about 4× slower than cost 10)

**In simple terms:** MD5 is like a photocopy—same input always gives the same output. Bcrypt is like mixing your password with random data unique to you, then running it through a slow blender 4,096 times. Even with two identical passwords, the results are completely different — but an attacker can still try guesses until they find the right one.

</div>
</details>

### HTTPS and Transport Security

Bcrypt protects passwords stored in `users.php`, but it cannot protect passwords traveling from your browser to the server. Without HTTPS, your password is sent in **plain text** over the network where it can be intercepted by WiFi sniffing, compromised routers, or ISP monitoring.

<div class="callout-warning">
<strong>HTTPS is required for production.</strong> The admin dashboard automatically blocks HTTP access from non-localhost addresses and returns a 403 error directing you to use HTTPS. This prevents passwords and session cookies from being transmitted unencrypted.
</div>

**How it works:**
- HTTPS encrypts all traffic using TLS before it leaves your browser
- Network observers see only encrypted data—your password cannot be read even if packets are intercepted
- The server decrypts the data and then hashes your password with bcrypt for storage

**Localhost exception:**

The admin allows HTTP on localhost (127.0.0.1 and ::1) because traffic stays on your machine and isn't exposed to network-level attacks. However, local malware or compromised system software could still intercept localhost traffic. For highly sensitive environments, consider using HTTPS even locally.

### Login & Session Security

**Brute-force protection:** Login attempts are rate-limited by IP address. After 5 failed attempts, the IP is locked out for 15 minutes. This prevents automated password guessing while allowing legitimate users to recover from typos.

**Timing attack prevention:** When you try to log in with an email that doesn't exist, Ava still performs a password verification against a dummy hash. This ensures response times don't reveal which email addresses are valid.

**Session security:**
- **Session fixation protection** — Session ID is regenerated on both login and logout
- **HTTP-only cookies** — JavaScript cannot access your session cookie (prevents XSS attacks)
- **SameSite protection** — Cookies include `SameSite=Lax` to prevent CSRF attacks
- **Secure flag** — When served over HTTPS, cookies are marked as secure-only

### CSRF Protection

Every form in the admin dashboard includes a CSRF token:

- **Generated securely** - Uses PHP's `random_bytes(32)` for cryptographically secure randomness
- **Timing-safe verification** - Token comparison uses `hash_equals()` to prevent timing attacks
- **Token regeneration** - Fresh token generated after form submissions

### Best Practices

| Practice | Why It Matters |
|----------|----------------|
| **Use a strong password** | 16+ characters with mixed case, numbers, and symbols. Consider using a password manager. |
| **Always use HTTPS in production** | Without HTTPS, session cookies and passwords can be intercepted. Most hosts offer free SSL via Let's Encrypt. |
| **Keep `users.php` out of Git** | It's gitignored by default, but double-check. Your password hash shouldn't be in version control. |
| **Assume leaked hashes are compromised** | If `users.php` leaks, change passwords promptly. Strong passwords reduce the chance of successful brute-force guessing. |
| **Review plugin permissions** | If you enable plugins that extend admin functionality (like redirects), understand what they can modify. |
| **Monitor admin logs** | Check `storage/logs/admin.log` periodically for suspicious login attempts. |
| **Change the admin path** | Setting `'path' => '/_secret-admin'` doesn't add real security, but reduces log spam from bots. |

