# Getting Started

## Prerequisites

- Docker and Docker Compose
- Git
- Python 3.10+ (for docs generation)

## Run the App (Laravel Sail)

```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail artisan test
```

## Run Documentation Locally

Install doc dependencies:

```bash
python3 -m pip install -r requirements-docs.txt
```

Start the docs server:

```bash
python3 -m mkdocs serve
```

Then open `http://127.0.0.1:8000`.
