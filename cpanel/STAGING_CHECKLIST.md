# Staging checklist (cPanel, no Terminal)

Target paths:
- Public docroot: `/home/torredeb/staging.torredebatalla.cl/public_html/staging`
- App root (private): `/home/torredeb/staging.torredebatalla.cl/laravel-app`

## 1) Build dependencies locally

On your PC (Windows) in the project folder:

- PHP deps:
  - `composer install --no-dev --optimize-autoloader`
- Frontend assets (if you rely on Vite build output):
  - `npm ci`
  - `npm run build`

## 2) Create upload zips

Run:

- `powershell -ExecutionPolicy Bypass -File cpanel/pack-staging.ps1`

It generates:
- `cpanel/dist/staging-public-YYYYMMDD-HHMMSS.zip`
- `cpanel/dist/staging-laravel-app-YYYYMMDD-HHMMSS.zip`

## 3) Upload + extract

### Public
Upload `staging-public.zip` into:
- `/home/torredeb/staging.torredebatalla.cl/public_html/staging`

Then **Extract**.

### App
Upload `staging-laravel-app.zip` into:
- `/home/torredeb/staging.torredebatalla.cl/laravel-app`

Then **Extract**.

## 4) Fix staging index.php

Edit:
- `/home/torredeb/staging.torredebatalla.cl/public_html/staging/index.php`

Point it to the app root:

```php
$appRoot = '/home/torredeb/staging.torredebatalla.cl/laravel-app';
```

And make sure it requires:
- `$appRoot . '/vendor/autoload.php'`
- `$appRoot . '/bootstrap/app.php'`

A ready template exists at `public/cpanel-index.template.php`.

## 5) Create .env on server

Create:
- `/home/torredeb/staging.torredebatalla.cl/laravel-app/.env`

Note: `.env` should NOT be uploaded inside the app zip.

Set at minimum:
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://staging.torredebatalla.cl`
- `APP_KEY=...` (generate locally via `php artisan key:generate --show`)
- DB credentials from cPanel MySQL (`DB_HOST=localhost` usually)

## 6) Database

No Terminal => use phpMyAdmin.

Recommended:
- Export local DB to SQL.
- Import SQL into staging DB.

## 7) Permissions

Ensure writable:
- `/home/torredeb/staging.torredebatalla.cl/laravel-app/storage`
- `/home/torredeb/staging.torredebatalla.cl/laravel-app/bootstrap/cache`

If you get 500 errors or uploads fail, it’s usually this.

## 8) Smoke test

- Visit `https://staging.torredebatalla.cl`
- Login/register
- View products
- Add to cart
- Checkout
- Admin -> upload calendar image
- Admin -> blog cover upload
