# AGENTS.md

Church website (GKKD Denpasar). Currently a stock Laravel 13 skeleton — only the `/` welcome route exists; no domain features yet. `CLAUDE.md` is a duplicate placeholder and is not a source of truth.

## Stack

- PHP `^8.3` (local PHP 8.4), Laravel 13, PHPUnit 12, Vite 8, Tailwind CSS v4, SQLite.
- Tests are PHPUnit — this repo does **not** use Pest.

## Commands

- First-time setup: `composer setup` (install, copy `.env`, `key:generate`, migrate, `npm install`, build).
- Dev (server + queue + logs + Vite together): `composer dev`, which runs `php artisan dev`. On Windows it uses `concurrently`; on Unix `@laravel/multiplex` (optional npm dep). Do not run `php artisan serve` alone — you'll miss Vite/queue/logs.
- Tests: `composer test` (runs `config:clear` then `php artisan test`). Single test: `php artisan test --filter=ExampleTest` or pass a file path.
- Format: `vendor/bin/pint` (Laravel preset; no `pint.json`).
- Frontend: `npm run dev` / `npm run build`.

## Testing

- `phpunit.xml` forces sqlite `:memory:`, array cache/session, sync queue, array mail. Tests never touch `database/database.sqlite`.

## Architecture

- Slim Laravel 13 bootstrap: routing, middleware, and exceptions are configured in `bootstrap/app.php` (there is no `app/Http/Kernel.php`).
- No `routes/api.php`. Adding API routes requires registering `api:` in `bootstrap/app.php` `withRouting(...)`. Health check is `/up`.
- Default DB is SQLite at `database/database.sqlite`, ignored via `database/.gitignore` (`*.sqlite*`). The MySQL block in `.env.example` is commented out.

## Frontend

- Tailwind v4 is CSS-first: design tokens live in `resources/css/app.css` under `@theme`. There is no `tailwind.config.js` or `postcss.config.js`.
- Vite inputs: `resources/css/app.css`, `resources/js/app.js`. Instrument Sans is fetched via the laravel-vite-plugin Bunny font loader.
- For landing-page/UI design work, use the `.agents/skills/design-taste-frontend` skill.
