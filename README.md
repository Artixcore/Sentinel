# Artixcore Sentinel

Sentinel is an AI-ready operations platform for monitoring websites, servers, agents, traffic, requests, incidents, and scheduled diagnostics from one command center.

## Stack

- Laravel 12 API and scheduler
- Next.js 16 dashboard
- MySQL 8.4 metrics store
- Redis 7 cache, queues, rate limits, and realtime event transport
- Docker Compose local environment
<img width="905" height="442" alt="image" src="https://github.com/user-attachments/assets/fcb3c625-2b2e-4fb3-b761-b7d8fffa0778" />

## Milestone 1

This first development milestone provides the production-oriented monorepo foundation, normalized monitoring schema, token-protected metric ingestion, asynchronous website checking, overview aggregation, a connected dashboard, Docker services, and CI. Broken-link crawling and full user authentication are scheduled for the next milestone.

## Start locally

1. Copy `.env.example` to `.env`.
2. Run `docker compose up --build`.
3. Run migrations: `docker compose exec api php artisan migrate --seed`.
4. Open `http://localhost:3000`.

The API is available at `http://localhost:8000/api/v1`. Queue workers and the Laravel scheduler run as separate services.

## Architecture

```text
Browser -> Next.js -> Laravel API -> MySQL
                          |       -> Redis
                          |       -> Queue workers
                          +------- Scheduled collectors
```

Never commit production credentials. Agent and collector tokens must be encrypted and injected at runtime.

## AWS Lightsail production

Production uses `docker-compose.prod.yml`, exposes the web and API containers only on loopback, and puts host Nginx in front for TLS termination. Copy `.env.production.example` to `.env`, replace every placeholder, install `deploy/nginx/sentinel.conf`, and use `deploy/update.sh` for repeatable releases. MySQL and Redis are not published to the internet.
