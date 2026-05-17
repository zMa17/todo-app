# AGENTS.md

## Tech stack

- **Laravel 13** + **SQLite** (`database/database.sqlite`). Eloquent ORM.
- **Pest v4** (not bare PHPUnit). `php artisan test` or `vendor/bin/pest`.
- **Vite** + **Tailwind CSS v3** for frontend assets. `npm run build` / `npm run dev`.
- **Laravel Pint** for PHP CS fixing (no custom config file).
- **Laravel Breeze** (Blade stack) for auth — login, register, profile management.
- **Alpine.js** included via Breeze for modal/dropdown interactions.
- `.npmrc` has `ignore-scripts=true` — run `npm run build` explicitly after `npm install`.

## Key commands

| Action | Command |
|--------|---------|
| Fresh install | `composer run setup` → `php artisan migrate` → `npm run build` |
| Dev servers | `composer run dev` (serves `php artisan serve` + `queue:listen` + Vite) |
| Test all | `composer run test` (runs `config:clear` then `php artisan test`) |
| Single test | `vendor/bin/pest --filter testName` |
| Migrate | `php artisan migrate` |
| Pint (lint) | `./vendor/bin/pint` |

## Auth

- **Breeze Blade stack** installed. Auth routes at `routes/auth.php`, controllers in `app/Http/Controllers/Auth/`.
- Login/register/password-reset/email-verify all work out of the box.
- Guest layout: `layouts/guest.blade.php` (centered card on gray bg).
- Authenticated layout: `layouts/app.blade.php` (top nav with dropdown).
- Profile management at `/profile` (name, email, password, delete account).

## Routes

| Route | Middleware | Controller |
|-------|-----------|------------|
| `/dashboard` | `auth + verified` | `DashboardController@index` |
| `/kategori` | `auth` | `KategoriController` (no `show`) |
| `/tag` | `auth` | `TagController` (no `show`) |
| `/todo` | `auth` | `TodoController` (no `show`) |

All resources are inside `Route::middleware('auth')` in `routes/web.php`.

## Dashboard architecture

- **`DashboardController`** — single `index()` method. Uses plain `if` statements for filtering (kategori_id, tag_id, search, prioritas, is_completed, deadline_from, deadline_to). Returns `dashboard` view with `todos`, `kategoris` (with count), `tags` (with count).
- **`dashboard.blade.php`** — extends Breeze's `layouts/app`. Two-column layout:
  - Left sidebar (`md:block hidden`, 260px, `bg-[#f6f5f4]`): quick filter by kategori (colored dots) and tag (lavender chips), "Filter Lanjutan" button for Alpine.js modal with full filter form.
  - Main content: inline "Tambah Todo Baru" form at top, todo card grid below.
- Inline add form posts to `todo.store`, then redirects back to dashboard.
- Active filters shown as dismissible chips above the card grid.

## Styling (Notion-inspired)

All colors from `DESIGN.md` used as inline Tailwind hex classes — **no custom CSS**:

| Notion Token | Hex | Usage |
|---|---|---|
| Primary | `#5645d4` | Buttons, links, focus ring |
| Surface | `#f6f5f4` | Sidebar bg, table header |
| Canvas | `#ffffff` | Cards, page bg |
| Hairline | `#e5e3df` | Borders, dividers |
| Hairline-strong | `#c8c4be` | Input borders |
| Ink | `#1a1a1a` | Heading text |
| Charcoal | `#37352f` | Body text |
| Steel | `#787671` | Secondary/muted text |
| Card-lavender | `#e6e0f5` | Tag badges |
| Success | `#1aae39` | Success messages |
| Error | `#e03131` | Delete, error msgs |
| Warning | `#dd5b00` | High priority dot |

- Buttons: `bg-[#5645d4] hover:bg-[#4534b3] text-white px-4 py-2 rounded-lg text-sm font-medium`
- Cards: `bg-white border border-[#e5e3df] rounded-xl p-5`
- Inputs: `border border-[#c8c4be] rounded-lg px-4 py-2.5 h-11 text-sm`
- Badges: `bg-[#e6e0f5] text-[#391c57] rounded text-xs font-medium`

Priority dots: high `bg-[#dd5b00]`, medium `bg-[#f5d75e]`, low `bg-[#787671]`.

## Code conventions

- Explicit per-column assignment in controllers (never `$request->all()`).
- `$fillable` defined in every model.
- `sync()` for many-to-many tag assignment.
- `DashboardController` uses simple `if` statements for filters (no chained closures).
- `TodoController::store()` assigns `auth()->id()` to `user_id`.
- CRUD controllers redirect to `route('dashboard')` after mutations.

## Views & CRUD

| Path | Layout | Purpose |
|---|---|---|
| `dashboard.blade.php` | `layouts/app` | Main dashboard (sidebar + add form + cards + filter modal) |
| `kategori/index.blade.php` | `layouts/app` | Manajemen Kategori table |
| `kategori/create.blade.php` | `layouts/app` | Tambah Kategori form |
| `kategori/edit.blade.php` | `layouts/app` | Edit Kategori form |
| `tag/index.blade.php` | `layouts/app` | Manajemen Tag table |
| `tag/create.blade.php` | `layouts/app` | Tambah Tag form |
| `tag/edit.blade.php` | `layouts/app` | Edit Tag form |
| `todo/edit.blade.php` | `layouts/app` | Edit Todo form (create is inline on dashboard) |

All extend `layouts/app` (Breeze default with top nav). `todo/create.blade.php` was removed — inline form on dashboard replaces it.

## Tests

- Feature tests use `TestCase` with in-memory SQLite (`DB_DATABASE=:memory:`).
- Breeze may add `RefreshDatabase` — tests that need auth must be authenticated.
- No factories/seeders for app entities (Kategori, Tag, Todo) — just `User::factory()` for auth.

## Directory layout (key paths)

```
app/Http/Controllers/
├── Auth/                    # Breeze auth controllers
├── DashboardController.php  # Simple if-based filtering
├── KategoriController.php
├── TagController.php
├── TodoController.php       # user_id on store, redirects to dashboard
└── ProfileController.php    # Breeze profile

resources/views/
├── layouts/app.blade.php    # Authenticated layout (top nav)
├── layouts/guest.blade.php  # Guest layout (login/register)
├── dashboard.blade.php      # Main dashboard
├── auth/                    # Breeze auth views
├── kategori/                # CRUD views
├── tag/                     # CRUD views
├── todo/edit.blade.php      # Only edit (create is inline on dashboard)
└── components/              # Breeze Blade components

routes/
├── web.php                  # Dashboard + CRUD routes (auth-protected)
└── auth.php                 # Breeze auth routes
```
