# Wedding Guest Management System (Laravel)

A bilingual Khmer/English starter app for wedding guest registration, check-in, and reporting.

## Features
- Dashboard counts: total guests, checked in, not arrived
- Register, edit, view, delete guests
- Record guest name, phone, side (bride/groom/both), table number, guest count, RSVP, notes
- Check-in action with timestamp
- Search/filter guest list
- Report page with guest/check-in totals and CSV export
- Khmer / English language toggle (session-based)
- Bootstrap 5 admin dashboard layout

## Requirements
- PHP 8.2+ (Laravel 12 requires PHP 8.2+)
- Composer
- MySQL/MariaDB or SQLite
- Existing Laravel 12 application

## Install into an existing Laravel project
1. Create a Laravel app:
   ```bash
   composer create-project laravel/laravel wedding-guest-management
   cd wedding-guest-management
   ```
2. Copy the folders/files in this package into the matching locations in your Laravel app, replacing `routes/web.php` if you are starting fresh.
3. Configure `.env` database settings. Example MySQL:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=wedding_guests
   DB_USERNAME=root
   DB_PASSWORD=
   ```
4. Create the database `wedding_guests` in MySQL/phpMyAdmin.
5. Register the locale middleware in `bootstrap/app.php` inside the existing `withMiddleware` callback. If the callback is not present, add one to the `Application::configure(...)->withMiddleware(...)` chain:
   ```php
   ->withMiddleware(function (\Illuminate\Foundation\Configuration\Middleware $middleware): void {
       $middleware->web(append: [
           \App\Http\Middleware\SetLocale::class,
       ]);
   })
   ```
   If your `bootstrap/app.php` already has a `withMiddleware` callback, add the `$middleware->web(append: [...])` line inside that callback rather than creating a second callback.
6. Run:
   ```bash
   php artisan key:generate
   php artisan migrate
   php artisan serve
   ```
7. Open `http://127.0.0.1:8000`.

## Files included
- `app/Models/Guest.php`
- `app/Http/Controllers/GuestController.php`
- `database/migrations/2026_10_21_000000_create_guests_table.php`
- `routes/web.php`
- `resources/views/layouts/app.blade.php`
- `resources/views/dashboard.blade.php`
- `resources/views/guests/index.blade.php`
- `resources/views/guests/create.blade.php`
- `resources/views/guests/edit.blade.php`
- `resources/views/guests/show.blade.php`
- `resources/views/reports/index.blade.php`
- `resources/lang/en/wedding.php`
- `resources/lang/km/wedding.php`

## Notes
- This starter intentionally has no login/authentication. Add Laravel Breeze or another authentication solution before putting it on a public internet server.
- CSV export opens/downloads a report and can be opened in Excel. For PDF export, install a PDF package such as `barryvdh/laravel-dompdf` and add a dedicated PDF route/view.
- The default UI loads Bootstrap from a CDN, so an internet connection is required for those styles.
