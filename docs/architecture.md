# Woodcraft Application Architecture

## Overview

Woodcraft is an e-commerce application for handcrafted wooden products built on Laravel 8 with a Blade and Tailwind CSS frontend. The system is structured around a clear separation of concerns between HTTP controllers, service classes, Eloquent models, and Blade view templates.

## Frontend

- Layouts: `resources/views/layouts` define shared shells for authenticated, guest, and application pages. They include navigation, footer, meta tags, and global scripts.
- Components: `resources/views/components` contains reusable view components for common UI elements such as inputs, buttons, navigation links, product gallery, and cart.
- Pages: Feature-specific views are grouped by domain (shops, cart, checkout, admin, user, legal, auth). Each page extends a layout and composes components.
- Assets: Tailwind-based styles are compiled from `resources/css/app.css` into `public/css/app.css` via Laravel Mix. JavaScript is bundled from `resources/js/app.js` and `resources/js/bootstrap.js` to `public/js/app.js`.
- JavaScript: Alpine.js is initialized in `resources/js/app.js` and used in layouts and components for interactivity (navigation, toasts, search, loading states).

## Backend

- Routing:
  - Web: `routes/web.php` defines public, authenticated, and admin routes for pages, checkout, orders, notifications, and product browsing.
  - API: `routes/api.php` exposes JSON endpoints under the `/api` prefix, including versioned routes under `/api/v1`.
  - Modular route files: Additional route groups in `routes/auth.php`, `routes/user.php`, `routes/admin.php`, `routes/legal.php`, and `routes/cart.php`.
- Controllers:
  - HTTP controllers are organized by domain under `app/Http/Controllers`, with dedicated namespaces for `Admin`, `Auth`, `Cart`, `Shop`, `User`, and `Legal`.
  - Controllers delegate reusable business logic to service classes where appropriate (for example `App\Services\CartService`).
- Services:
  - `CartService` orchestrates cart operations including add, update quantity, remove, clear, merge guest cart, and summary aggregation.
  - `CheckoutService` and `NotificationService` encapsulate checkout and notification-specific workflows.
- Middleware:
  - Core HTTP middleware is configured in `App\Http\Kernel`.
  - `AdminMiddleware` protects admin-only routes.
  - `BackendToggle` uses the `BACKEND_DISABLED` configuration flag to temporarily disable backend services for both web and API routes.

## Data Layer

- Models:
  - `Product` represents sellable items and uses soft deletes, attribute casting, scoping (`active`, `inStock`), and accessors for image URL and formatted price.
  - `Shop` represents legacy shop-style records and provides filtering scopes for material, price range, and text search.
  - `Cart`, `CartItem`, `Order`, `OrderItem`, `Address`, `Notification`, `User`, `ShopImage`, and `ProductImage` model other core entities and relationships.
- Migrations:
  - Base tables for users, products, addresses, carts, orders, and related items live in `database/migrations`.
  - `RenameShopsTableToProducts` handles compatibility between legacy `shops` and current `products` tables.
- Database configuration:
  - `config/database.php` configures MySQL, PostgreSQL, SQL Server, and SQLite connections.
  - `.env` defines the default connection and credentials.

## Security

- Authentication:
  - Laravel Breeze-style authentication with login, registration, password reset, and email verification tests.
  - Guards and providers configured in `config/auth.php`.
- Authorization:
  - Middleware-based role checking for admin routes via `AdminMiddleware`.
  - Policies for orders and reviews in `app/Policies`.
- Input validation:
  - Form request classes under `app/Http/Requests` validate add-to-cart, checkout, and authentication inputs.
  - API endpoints use request validation and rate limiting where appropriate (for example add-to-cart in `ShopController`).
- Protection:
  - CSRF protection through `VerifyCsrfToken`.
  - CORS handled via `fruitcake/laravel-cors` and `config/cors.php`.
  - Rate limiting for APIs via `throttle:api` and custom use of `RateLimiter` in cart operations.

## Observability

- Logging:
  - Default `stack` channel aggregates logs into the `single` file channel.
  - Additional channels include `daily`, `slack`, `papertrail`, `stderr`, and `syslog`.
  - `.env` supports configuration of log level and optional Slack and Papertrail destinations.
- Monitoring and alerts:
  - Slack channel may be enabled by setting `LOG_SLACK_WEBHOOK_URL`.
  - Papertrail can be configured with `PAPERTRAIL_URL` and `PAPERTRAIL_PORT`.

## Build, Testing, and CI

- Build:
  - Laravel Mix configuration in `webpack.mix.js` compiles and versions CSS and JavaScript assets.
  - Tailwind CSS is configured via `tailwind.config.js` with project-specific colors, typography, and layout tokens.
- Testing:
  - PHPUnit tests under `tests` include auth feature tests, example tests, and additional feature tests for backend toggling and API versioning.
- CI:
  - GitHub Actions workflow at `.github/workflows/ci.yml` installs dependencies, builds assets, and runs the test suite on pushes and pull requests.

