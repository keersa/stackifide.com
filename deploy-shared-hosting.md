# Deploying to shared hosting (fixed document root = public_html)

Use this when you **cannot** change the domain's document root (e.g. HostGator cPanel). The web root stays `public_html`; Laravel runs from a subfolder.

## 1. Upload the Laravel app into a subfolder

Upload your **entire** project into a subfolder of `public_html`. Example:

- `public_html/stackifide/app/`
- `public_html/stackifide/bootstrap/`
- `public_html/stackifide/config/`
- `public_html/stackifide/database/`
- `public_html/stackifide/public/`   ← leave this as-is for now
- `public_html/stackifide/resources/`
- `public_html/stackifide/routes/`
- `public_html/stackifide/storage/`
- `public_html/stackifide/vendor/`
- `public_html/stackifide/.env`
- `public_html/stackifide/artisan`
- etc.

So the Laravel root is at `public_html/stackifide/`. You can use another name (e.g. `app` or `laravel`) instead of `stackifide`.

## 2. Copy public assets into public_html

Copy the **contents** of `public/` into `public_html/` (the actual document root):

- `public/index.php` → **do not copy yet** (use the special one below)
- `public/.htaccess` → copy to `public_html/.htaccess`
- `public/robots.txt` → copy to `public_html/robots.txt`
- `public/build/` → copy entire folder to `public_html/build/`
- `public/hot` → copy to `public_html/hot` (if present)

Then use the **special** index file:

- Copy `public/index-for-public-html.php` from this repo to `public_html/index.php` (rename it to `index.php`).

Open `public_html/index.php` and set the subfolder name on the line that says:

```php
$laravelDir = 'stackifide';
```

Change `stackifide` to the exact folder name you used in step 1 (e.g. `app` or `laravel`).

## 3. Block web access to the Laravel folder

So that users cannot access files under `public_html/stackifide/` directly, add a `.htaccess` inside that folder:

**Create `public_html/stackifide/.htaccess`** with:

```apache
Require all denied
```

(or `Deny from all` if your server uses Apache 2.2 syntax).

This prevents anyone from opening `yoursite.com/stackifide/.env` or other files.

## 4. Storage link (if you use storage/app/public)

From SSH or cPanel File Manager / Terminal, create a symlink:

- **Link:** `public_html/storage`
- **Target:** `public_html/stackifide/storage/app/public`

If your host does not allow symlinks, you may need to use a custom route or skip public storage.

## 5. Environment and permissions

- Put your production `.env` in the Laravel root, e.g. `public_html/stackifide/.env`.
- Set `APP_URL` to your real URL (e.g. `https://yourdomain.com`).
- Ensure `public_html/stackifide/storage` and `public_html/stackifide/bootstrap/cache` are writable by the web server (e.g. chmod 775 or whatever your host requires).

## 6. Summary

| Location | Purpose |
|----------|--------|
| `public_html/index.php` | From `index-for-public-html.php`, with correct `$laravelDir` |
| `public_html/.htaccess` | From Laravel `public/.htaccess` |
| `public_html/build/`, etc. | Rest of Laravel `public/` contents |
| `public_html/stackifide/` | Full Laravel app (app, bootstrap, config, vendor, .env, etc.) |
| `public_html/stackifide/.htaccess` | `Require all denied` to block direct access |

After this, `https://yourdomain.com` should load Laravel. If you use a different subfolder name, remember to set `$laravelDir` in `public_html/index.php`.
