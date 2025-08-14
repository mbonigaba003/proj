# School Dashboard (PHP)

A modern, responsive school dashboard built with PHP, vanilla JS and CSS. Includes dark mode, widgets, announcements, a simple calendar, and Chart.js analytics.

## Quick start

- PHP 8+ required.
- From the project root:

```bash
php -S 0.0.0.0:8080 -t public
```

Then open http://localhost:8080 in your browser.

## Structure

- `public/` – Web root with `index.php`, assets
- `api/` – API endpoints returning JSON
- `app/` – Bootstrap and helpers

## Notes

- Data is mocked via `get_demo_data()` in `app/bootstrap.php` for demo purposes. Replace with your database layer when ready.
