# Laravel 13 API Skeleton

A production-ready Laravel 13 API boilerplate built with a layered architecture, high-performance Swoole/Octane runtime, and a full Docker setup. Designed to be the starting point for robust RESTful microservices.

---

## Table of Contents

- [Requirements](#requirements)
- [Tech Stack](#tech-stack)
- [Architecture Overview](#architecture-overview)
- [Project Structure](#project-structure)
- [Getting Started](#getting-started)
  - [Local Setup](#local-setup)
  - [Docker Setup](#docker-setup)
- [Configuration](#configuration)
- [API Endpoints](#api-endpoints)
- [Middleware](#middleware)
- [Architectural Patterns](#architectural-patterns)
  - [Repository Pattern](#repository-pattern)
  - [Service Layer](#service-layer)
  - [Mediator Pattern](#mediator-pattern)
  - [DTO Pattern](#dto-pattern)
  - [Filter Pattern](#filter-pattern)
- [Helper Functions](#helper-functions)
- [Localization](#localization)
- [Code Quality](#code-quality)
- [Testing](#testing)
- [License](#license)

---

## Requirements

- PHP >= 8.3
- Composer
- SQLite / MySQL / PostgreSQL
- Redis (optional, for caching/queues)
- Docker & Docker Compose (for containerized setup)

---

## Tech Stack

| Layer | Package / Tool |
|---|---|
| Framework | Laravel 13.8 |
| HTTP Server | Laravel Octane + Swoole |
| API Response | `mehrand/api-response` |
| Exception Handling | `mehrand/api-exceptions` |
| Query Filtering | `agog/osmose` |
| Code Quality | `nunomaduro/phpinsights` |
| Code Style | Laravel Pint |
| Testing | PHPUnit 12 |
| Dev Tooling | Laravel Pail (logs), Laravel Pao |

---

## Architecture Overview

```
HTTP Request
    │
    ▼
Middleware (JsonMiddleware, RequestLoggerMiddleware, SecretKeyMiddleware)
    │
    ▼
Controller (Api/V1)
    │
    ├── FormRequest (validation)
    ├── Filter (OsmoseFilter — query building)
    │
    ▼
Service Layer
    │
    ├── DTO (data transfer between layers)
    ├── Mediator (cross-cutting orchestration)
    │
    ▼
Repository Layer
    │
    ▼
Eloquent Model
```

All API routes are versioned under the `/api/v1` prefix and go through the `api` middleware group plus `RequestLoggerMiddleware`.

---

## Project Structure

```
app/
├── DTO/                        # Data Transfer Objects
│   ├── Auth/SampleDTO.php
│   └── Contracts/
│       ├── FromRequestDTOInterface.php
│       └── ToArrayDTOInterface.php
├── Helpers/
│   └── functions.php           # Global helper functions
├── Http/
│   ├── Controllers/Api/V1/
│   │   ├── HealthCheckController.php
│   │   └── SampleController.php
│   ├── Filters/
│   │   └── SampleFilter.php    # Osmose query filter
│   ├── Middleware/
│   │   ├── JsonMiddleware.php
│   │   ├── RequestLoggerMiddleware.php
│   │   └── SecretKeyMiddleware.php
│   ├── Requests/
│   │   ├── SampleRequest.php
│   │   └── Traits/
│   │       └── RequestDefaultValueTrait.php
│   └── Resources/
│       ├── SampleResource.php
│       └── Traits/
│           └── S3Resource.php
├── Mediators/
│   ├── SampleMediator.php
│   └── Contracts/
│       ├── BaseMediator.php
│       ├── BaseMediatorInterface.php
│       └── HasRepositoryInterface.php
├── Models/
│   └── Sample.php
├── Providers/
│   └── AppServiceProvider.php
├── Repositories/
│   ├── SampleRepository.php
│   └── Contracts/
│       ├── BaseRepository.php
│       ├── BaseRepositoryInterface.php
│       ├── SampleRepositoryInterface.php
│       └── Traits/BaseRepositoryTrait.php
└── Services/
    ├── SampleService.php
    └── Contracts/
        ├── BaseService.php
        ├── BaseServiceInterface.php
        ├── BaseDatabaseServiceInterface.php
        ├── DataServiceInterface.php
        ├── HasMediatorInterface.php
        └── Traits/
            ├── BaseServiceTrait.php
            └── WebFilter.php

config/
├── insights.php                # PHP Insights code quality config
├── osmose.php                  # Query filter date ranges & model namespace
└── settings.php                # App-specific settings (secret key)

docker/
├── Dockerfile                  # PHP 8.3 + Swoole + MongoDB + Redis extensions
├── entrypoint.sh               # Container startup script
├── supervisord.conf            # Runs Octane/Swoole on port 8080
└── php/
    ├── php.ini-development
    └── php.ini-production

lang/
├── en/                         # English translations
└── fa/                         # Persian (Farsi) translations
```

---

## Getting Started

### Local Setup

**1. Clone and install**

```bash
git clone <repository-url>
cd laravel13-skeleton
```

**2. One-command setup** (installs deps, copies `.env`, generates key, runs migrations):

```bash
composer run setup
```

**3. Start the development server**

```bash
composer run dev
```

This concurrently starts:
- `php artisan serve` — HTTP server
- `php artisan queue:listen` — Queue worker
- `php artisan pail` — Log viewer

### Docker Setup

**1. Copy the environment file**

```bash
cp .env.example .env
```

**2. Build and start containers**

```bash
docker-compose up -d --build
```

The app will be available at `http://localhost:9800`.

The Docker setup runs **Laravel Octane with Swoole** via Supervisor on port `8080` inside the container (mapped to `9800` on the host), with **8 worker processes**.

**Services:**
- `sample-app` — PHP 8.3 application container
- `sample-redis` — Redis (alpine)

---

## Configuration

Copy `.env.example` to `.env` and configure the following variables:

| Variable | Description | Default |
|---|---|---|
| `APP_NAME` | Application name | `Laravel` |
| `APP_ENV` | Environment (`local`, `production`) | `local` |
| `APP_DEBUG` | Enable debug mode | `true` |
| `APP_URL` | Application base URL | `http://localhost` |
| `DB_CONNECTION` | Database driver | `sqlite` |
| `DB_HOST` | Database host | `127.0.0.1` |
| `DB_PORT` | Database port | `3306` |
| `DB_DATABASE` | Database name | — |
| `DB_USERNAME` | Database user | — |
| `DB_PASSWORD` | Database password | — |
| `REDIS_HOST` | Redis host | `127.0.0.1` |
| `REDIS_PORT` | Redis port | `6379` |
| `CACHE_STORE` | Cache driver | `database` |
| `QUEUE_CONNECTION` | Queue driver | `database` |
| `ALLOWED_SECRET` | Secret key for `SecretKeyMiddleware` | — |
| `LOG_CHANNEL` | Default log channel | `stack` |

---

## API Endpoints

All endpoints are prefixed with `/api/v1`.

| Method | URI | Description |
|---|---|---|
| `GET` | `/up` | Laravel built-in health check |
| `GET` | `/api/v1/health-check` | Application health check (returns app name, environment, debug mode) |

**Health Check Response:**

```json
{
  "success": true,
  "message": "Action successfully done",
  "data": {
    "app_name": "Laravel",
    "environment": "local",
    "app_debug": true
  }
}
```

> `SampleController` demonstrates the full CRUD pattern (list with filtering/pagination via `GET` and update via a transaction-wrapped `PUT`/`POST`) and serves as the template for new resource controllers.

---

## Middleware

### `RequestLoggerMiddleware`

Automatically logs every API request and response to the `request_log` channel. Log levels are determined by the HTTP status code:

| Status Range | Level | Message |
|---|---|---|
| 2xx | `info` | Successful request |
| 4xx | `alert` | Client Failed |
| 5xx | `critical` | Internal Server Failed |
| Other | `error` | Gateway Failed |

Each log entry includes: IP address, timestamp, URL, HTTP method, request payload, query params, headers, and any error messages.

### `SecretKeyMiddleware`

Protects routes by validating the `allowed_secret` request header against `ALLOWED_SECRET` in `.env`. Throws `AuthenticationException` on mismatch.

Usage in routes:

```php
Route::middleware(SecretKeyMiddleware::class)->group(function () {
    // protected routes
});
```

### `JsonMiddleware`

Ensures all requests and responses are treated as JSON.

---

## Architectural Patterns

### Repository Pattern

Every model has a corresponding repository that encapsulates all database interactions. `BaseRepository` provides ready-made methods via `BaseRepositoryTrait`:

| Method | Description |
|---|---|
| `create(array $payload)` | Create a model, optionally tracking `created_by`/`updated_by` |
| `update(Model $model, array $payload)` | Update a model, optionally tracking `updated_by` |
| `delete(Model $model)` | Soft/hard delete, optionally tracking `deleted_by` |
| `findByAttribute(string $attr, mixed $value)` | Find a single record by a column |
| `findInByAttribute(string $attr, array $value)` | Find multiple records by a column (whereIn) |
| `findOrCreate(array $attrs)` | Find or create a record |
| `updateOrCreate(array $attrs, array $data)` | Update or create a record |
| `changeStatus(Model $model, string $status)` | Update a status column |
| `findByMetaData(array $meta)` | Query by multiple conditions |
| `updateWithCondition(array $payload, array $values)` | Batch update by condition |
| `findAll(array $with)` | Fetch all records with optional eager loading |

**Creating a new repository:**

```php
// Interface
interface ProductRepositoryInterface extends BaseRepositoryInterface {}

// Implementation
class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }
}
```

### Service Layer

Services contain all business logic and depend on repositories via interface injection. `BaseService` provides:

- `getView(Model $model, string $resource)` — wrap a model in an API resource
- `update(Model $model, ToArrayDTOInterface $dto)` — delegate update to repository
- `log(Model $model, string $foreignKey, array $attributes)` — create an audit log entry
- `addListConditions(array $conditions)` — apply where/whereIn filters to a query chain

Services using `WebFilter` trait gain chainable query-builder methods (`select`, `with`, `where`, `whereIn`, `whereHas`, `orderBy`, `groupBy`, `paginate`) and the `getFilter()` + `renderFilter()` pattern for paginated list endpoints.

**Creating a new service:**

```php
class ProductService extends BaseService implements DataServiceInterface
{
    use WebFilter;

    public function __construct(ProductRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function getFilter(OsmoseFilter $filter, ?Model $model = null, ?string $resource = null, array $conditions = []): array
    {
        return $this->filter($filter, $this->repository->getModel())
            ->orderBy('created_at', 'DESC')
            ->paginate()
            ->renderFilter($resource);
    }
}
```

### Mediator Pattern

Mediators handle cross-cutting concerns and orchestration between multiple services or repositories. They are lazily resolved inside services that implement `HasMediatorInterface`.

```php
class SampleService extends BaseService implements DataServiceInterface
{
    public function mediatorClass(): BaseMediatorInterface
    {
        return app()->make(SampleMediator::class);
    }
}
```

`BaseMediator` provides `setService()`, `getService()`, `setRepository()`, `getRepository()`, and an assertion helper `checkAssertHasValue()`.

### DTO Pattern

DTOs (Data Transfer Objects) are immutable value objects that carry validated data between the HTTP layer and the service layer, decoupling `FormRequest` from business logic.

Every DTO implements:
- `FromRequestDTOInterface` — `static fromRequest(FormRequest $request): static`
- `ToArrayDTOInterface` — `toArray(?Model $model = null): array`

**Example:**

```php
// In a Controller
$dto = app()->make(SampleDTO::class)->fromRequest($request);
$this->service->sample($dto);
```

### Filter Pattern

Filters use the `agog/osmose` package to build Eloquent query builders from HTTP query parameters declaratively. Each filter class defines a `residue()` method that maps query param keys to query builder closures.

**Example — `SampleFilter`:**

```php
public function residue(): array
{
    return [
        'code' => static fn(Builder $q, $v) => $q->where('code', (int) $v),
        'full_name' => static fn(Builder $q, $v) => $q->where('full_name', 'like', "%{$v}%"),
    ];
}
```

**Pagination query parameters:**

| Parameter | Description |
|---|---|
| `page_size` or `pageSize` | Number of items per page |
| `current` or `page` | Current page number |
| `sorter` | JSON-encoded sort object, e.g. `{"created_at":"descend"}` |

---

## Helper Functions

Globally available functions defined in `app/Helpers/functions.php`:

| Function | Signature | Description |
|---|---|---|
| `toman` | `toman(int $amount): string` | Formats a number with thousand separators (Iranian Toman currency) |
| `toJalali` | `toJalali(mixed $timestamp, string $format = 'Y/m/d'): string` | Converts a Gregorian date/timestamp to Persian (Jalali) calendar format |
| `toGregorian` | `toGregorian(string $jalaliDate, string $format = 'Y-m-d'): string` | Converts a Jalali date string (`Y/m/d`) back to Gregorian |
| `getRealIp` | `getRealIp(): string` | Extracts the real client IP, respecting `X-Forwarded-For` and `X-Real-IP` headers |
| `persianDigits` | `persianDigits(int\|string $number): string` | Converts Western Arabic digits to Eastern Arabic/Persian digits |

---

## Localization

The project ships with translations for **English** (`lang/en/`) and **Persian/Farsi** (`lang/fa/`).

| File | Description |
|---|---|
| `lang/en/auth.php` | Authentication messages |
| `lang/en/errors.php` | Error messages |
| `lang/en/validation.php` | Validation messages |
| `lang/fa/messages.php` | App messages in Persian |
| `lang/fa/validation.php` | Validation messages in Persian |
| `lang/fa/errors.php` | Error messages in Persian |

Locale is configured via `APP_LOCALE` and `APP_FALLBACK_LOCALE` in `.env`.

---

## Code Quality

This project uses [PHP Insights](https://phpinsights.com/) for automated code quality analysis across four dimensions: Quality, Complexity, Architecture, and Style.

**Run the analysis:**

```bash
php artisan insights
```

**Minimum passing thresholds** (configurable via `.env`):

| Metric | Minimum |
|---|---|
| Quality | 90% |
| Complexity | 90% |
| Architecture | 90% |
| Style | 90% |

**Run Laravel Pint (code style fixer):**

```bash
./vendor/bin/pint
```

---

## Testing

```bash
# Run all tests
composer run test

# Run with PHPUnit directly
php artisan test

# Run a specific test
php artisan test --filter ExampleTest
```

Tests are located in:
- `tests/Feature/` — HTTP/integration tests
- `tests/Unit/` — Unit tests

---

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
