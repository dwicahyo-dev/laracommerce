
## Installation

```php
// Installing dependencies
composer install

// Copy .env-example to .env file
cp .env-example .env

// Generate App Key
php artisan key:generate

// Run the migrations and seeders
php artisan migrate:fresh --seed

// Create the symbolic storage link filesytem
php artisan storage:link

```
