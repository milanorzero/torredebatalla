# Deploy to cPanel (no SSH) — staging.torredebatalla.cl

This project is Dockerized for local dev, but **cPanel deployments are non-Docker**.

Your staging subdomain document root is:

- `/staging.torredebatalla.cl/public_html/staging`

Goal: keep **Laravel app code outside** `public_html` and expose only `public/`.

## A) Folder layout on the server (recommended)

Create this structure using cPanel File Manager:

- `/staging.torredebatalla.cl/laravel-app/`  ← Laravel project (everything except `public/`)
- `/staging.torredebatalla.cl/public_html/staging/` ← public web root (contents of `public/`)

## B) Upload files

### 1) Upload Laravel app (outside public_html)

Upload **everything** from your repo **except** the `public/` folder into:

- `/staging.torredebatalla.cl/laravel-app/`

Important:
- Upload `vendor/` too (because you have **no Terminal** to run `composer install`).
  - Do this by running locally: `composer install --no-dev --optimize-autoloader`
  - Then upload the resulting `vendor/`.

### 2) Upload public files (document root)

Upload the contents of the repo `public/` folder into:

- `/staging.torredebatalla.cl/public_html/staging/`

This includes:
- `index.php`
- `.htaccess`
- `front_end/`
- `products/`
- `admin/`

## C) Point public/index.php to the real app

In the server path `/staging.torredebatalla.cl/public_html/staging/index.php`, update these two lines so they point to your app folder:

- `require __DIR__.'/../vendor/autoload.php';`
- `$app = require_once __DIR__.'/../bootstrap/app.php';`

For the recommended layout above, the relative path from `public_html/staging` to `laravel-app` is:

- `../../laravel-app/...`

So it becomes:

- `require __DIR__.'/../../laravel-app/vendor/autoload.php';`
- `$app = require_once __DIR__.'/../../laravel-app/bootstrap/app.php';`

A ready-to-copy template is in `public/cpanel-index.template.php` in this repo.

## D) .env for staging

Create `/staging.torredebatalla.cl/laravel-app/.env` based on `.env.example`.

Must set:
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://staging.torredebatalla.cl`
- `APP_KEY=...` (generate locally)
- DB:
  - `DB_HOST=localhost` (usually)
  - `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` from cPanel MySQL

### Generate APP_KEY locally

On your local machine (Docker is fine):

```bash
docker compose exec app php artisan key:generate --show
```

Copy the output into staging `.env`.

## E) Database (no Terminal)

Because you cannot run `php artisan migrate` on the server, use phpMyAdmin:

### Option 1 (recommended): export current schema+data from local

1) From local Docker DB, export:

```bash
docker compose exec -T mysql mysqldump -ularavel -plaravel torredebatalla_db > torredebatalla.sql
```

2) In cPanel phpMyAdmin, import `torredebatalla.sql` into the staging database.

### Option 2: run migrations locally and export

Run migrations locally, then export the DB and import in staging.

## F) Permissions

Ensure these folders are writable by PHP:

- `/staging.torredebatalla.cl/laravel-app/storage`
- `/staging.torredebatalla.cl/laravel-app/bootstrap/cache`

If uploads fail, this is usually the reason.

## G) Storage link

This app can operate without `storage:link` for payment proof admin access.
Uploads are stored in `storage/app/public/...`, so ensure `storage/` is writable.

## H) Common 500 errors checklist

- Wrong paths in `public_html/staging/index.php`
- Missing `vendor/` (Composer not installed)
- `.env` missing or `APP_KEY` empty
- DB credentials wrong
- Permissions on `storage/` and `bootstrap/cache/`

