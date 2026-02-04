# Deployment (VPS + Docker)

This repo is already Dockerized for local dev. For production, the simplest reliable setup is:

- A VPS (Ubuntu 22.04/24.04)
- Docker + Docker Compose plugin
- A reverse proxy with TLS (recommended: Cloudflare OR host Nginx + Certbot)

## 1) DNS

Point your domain to the VPS IP:

- `A` record: `@` -> `YOUR_SERVER_IP`
- `A` record: `www` -> `YOUR_SERVER_IP`

## 2) Server prep

Install Docker + Compose (Ubuntu):

- https://docs.docker.com/engine/install/ubuntu/

Clone the project:

```bash
git clone <your-repo-url> /opt/torredebatalla
cd /opt/torredebatalla
```

## 3) Environment

Create your production env file (Laravel):

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://your-domain.cl`
- Set DB credentials (match the `mysql` service)
- Set mail credentials
- Set MercadoPago keys

Generate app key (inside container):

```bash
docker compose exec app php artisan key:generate --force
```

## 4) Build dependencies

Install PHP dependencies:

```bash
docker compose exec app composer install --no-dev --optimize-autoloader
```

Build frontend assets **on the server host** (Node is not inside the PHP container):

```bash
npm ci
npm run build
```

## 5) Start production services

Use the production override:

```bash
docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d --build
```

Run migrations:

```bash
docker compose exec app php artisan migrate --force
```

Cache config/routes/views:

```bash
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache
```

## 6) TLS / HTTPS

### Option A (easy): Cloudflare

- Put the domain behind Cloudflare
- Set SSL/TLS mode to **Full (strict)** (recommended)
- Proxy traffic to your VPS

### Option B (classic): Host Nginx + Certbot

Run the Laravel nginx container on a high port and use host Nginx as TLS terminator.
(You can also keep container on port 80 and do Certbot on host using webroot, but reverse-proxy is cleaner.)

## 7) Scheduler / queue

If you use scheduler:

- Add cron on the host: `* * * * * docker compose -f /opt/torredebatalla/docker-compose.yml -f /opt/torredebatalla/docker-compose.prod.yml exec -T app php artisan schedule:run >> /dev/null 2>&1`

If you use queues:

- Run a worker (systemd or a dedicated container).

## 8) Smoke checks

- Home page loads over HTTPS
- Add to cart + checkout works
- MercadoPago return/webhook hits the correct URL
- Mail sending works

