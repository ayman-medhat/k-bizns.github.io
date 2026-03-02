# Deployment Notes

## App Deployment

This is a Laravel application and must run on a PHP-capable host with:

- PHP 8.2+
- MySQL 8+
- Composer
- Queue/worker support if background jobs are used

## Docs Deployment

MkDocs generates static files into the `site/` directory:

```bash
python3 -m mkdocs build
```

The generated `site/` folder can be deployed to static hosting or GitHub Pages.
