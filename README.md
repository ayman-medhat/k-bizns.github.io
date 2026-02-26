# k-bizns

A business CRM application built with Laravel.

## Tech Stack

- Laravel 12
- PHP 8.2+
- MySQL 8
- Vite + Tailwind CSS

## Local Development (Sail)

```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail artisan test
```

## Notes

- Multi-tenant company structure
- Root user protections
- Role and permission support via Spatie
