# UniShopnex

Multi-Vendor SaaS E-commerce Platform built with Laravel 13, Blade, Tailwind CSS, Alpine.js, Breeze, Sanctum, queues, scheduling, policies, notifications, and a learning-first architecture.

## Why this project exists

This codebase is designed to help you learn the Laravel roadmap through one real application instead of many disconnected mini-projects. It intentionally demonstrates:

- Basics: routing, controllers, Blade, migrations, seeders, factories, Eloquent relationships
- Intermediate: form requests, auth, middleware, authorization, uploads, API resources, Sanctum
- Advanced: service container bindings, repositories, services, events, listeners, jobs, notifications, scheduling, caching
- Real-world practices: thin controllers, eager loading, pagination, security checks, Docker readiness, CI, structured documentation

## Stack

- Laravel 13
- PHP 8.3+
- MySQL
- Blade + Tailwind CSS + Alpine.js
- Laravel Breeze
- Laravel Sanctum
- Spatie Laravel Permission
- Database queues and scheduler
- PHPUnit
- Vite

## Core roles

- Admin
- Vendor
- Customer

## Main feature map

- Public storefront with landing page, catalog, product details, store pages, search, filtering, featured sections
- Customer area with auth, addresses, cart, checkout, wishlist, orders, profile
- Vendor area with dashboard, store profile, product CRUD, order visibility, analytics
- Admin area with dashboards, users, vendors, categories, products, orders, settings
- API with auth, products, categories, cart, orders, profile
- Event-driven order placement and vendor approval notifications
- Scheduled commands for sales summaries, abandoned cart cleanup, and low stock checks

## Learning roadmap

1. Phase 1: Foundation
   Read [docs/architecture.md](/Users/midu/Downloads/UniShopnex/docs/architecture.md), inspect `routes/`, `app/Models`, `database/migrations`, `database/seeders`.
2. Phase 2: Storefront and Auth
   Explore `app/Http/Controllers/Storefront`, `resources/views/storefront`, Breeze auth controllers and guest layouts.
3. Phase 3: Vendor System
   Explore `app/Http/Controllers/Vendor`, vendor policies, product requests, store profile flow.
4. Phase 4: Cart and Orders
   Study `app/Services/CartService.php`, `app/Services/CheckoutService.php`, order events/jobs/notifications.
5. Phase 5: Admin System
   Explore `app/Http/Controllers/Admin`, settings, vendor approval flow, activity logging.
6. Phase 6: API
   Read `routes/api.php`, `app/Http/Controllers/Api`, `app/Http/Resources`.
7. Phase 7: Queues, Events, Cache, Testing
   Read `app/Events`, `app/Listeners`, `app/Jobs`, `app/Notifications`, `routes/console.php`, and feature tests.
8. Phase 8: Deployment and Ecosystem
   Review `docker-compose.yml`, `.github/workflows/ci.yml`, `.env.example`, and architecture notes for Livewire/Filament expansion.

## Local setup

```bash
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
npm run build
php artisan serve
```

Run the queue worker in another terminal:

```bash
php artisan queue:work
```

Run the scheduler locally:

```bash
php artisan schedule:work
```

Run tests:

```bash
php artisan test
```

## Demo credentials

- Admin: `admin@unishopnex.test` / `password`
- Vendor 1: `vendor1@unishopnex.test` / `password`
- Vendor 2: `vendor2@unishopnex.test` / `password`
- Customer 1: `customer1@unishopnex.test` / `password`

## API quick start

Public endpoints:

- `GET /api/products`
- `GET /api/products/{productSlug}`
- `GET /api/categories`

Auth endpoints:

- `POST /api/register`
- `POST /api/login`
- `POST /api/logout`

Protected endpoints:

- `GET/PATCH /api/profile`
- `GET /api/cart`
- `POST /api/cart/items`
- `PATCH /api/cart/items/{product}`
- `DELETE /api/cart/items/{product}`
- `GET /api/orders`
- `POST /api/orders`
- `GET /api/orders/{order}`

## Queue + scheduler examples

- Order placement dispatches `OrderPlaced`
- Listener queues `SendOrderConfirmationJob`
- Vendor approval dispatches `VendorApproved`
- `sales:send-daily-summaries`
- `carts:cleanup-abandoned`
- `inventory:check-low-stock`

## Docker

```bash
docker compose up --build
```

The compose file provisions:

- `app` PHP-FPM container
- `nginx` web server
- `mysql` database

## Future expansion

The project is intentionally structured to support:

- Livewire components for richer interactivity
- Filament admin panels
- Inertia.js frontends in parallel with Blade

## Notes

- Storage uploads use the `public` disk
- API auth uses Sanctum personal access tokens
- Role checks use Spatie Permission middleware plus policies
- Tests use in-memory SQLite by default
