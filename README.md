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

## Documentation (MkDocs)

```bash
python3 -m pip install -r requirements-docs.txt
python3 -m mkdocs serve
```

Build static docs:

```bash
python3 -m mkdocs build
```

## Publish Website On GitHub (Pages)

This repo now includes a GitHub Actions workflow at
`.github/workflows/deploy-pages.yml` that publishes the MkDocs site on every
push to `main`.

1. Open repository settings on GitHub.
2. Go to `Pages`.
3. Set source to `GitHub Actions`.
4. Push to `main` and wait for the `Deploy Docs To GitHub Pages` workflow.

Note: GitHub Pages serves static files only. Laravel (PHP + MySQL) must be
deployed on a PHP host. Pages in this setup publishes your project website/docs.

## Notes

- Multi-tenant company structure
- Root user protections
- Role and permission support via Spatie
