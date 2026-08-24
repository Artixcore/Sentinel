# Artixcore Sentinel

Sentinel is an AI-ready operations platform for monitoring websites, servers, agents, traffic, requests, incidents, and scheduled diagnostics from one command center.

## Stack

- Laravel 12 API and scheduler
- Next.js 16 dashboard
- MySQL 8.4 metrics store
- Redis 7 cache, queues, rate limits, and realtime event transport
- Docker Compose local environment

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
