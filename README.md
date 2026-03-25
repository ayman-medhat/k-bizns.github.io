# Kashmos ERP

A comprehensive, multi-tenant enterprise resource planning system built with Laravel 13 and Filament v4.

## Tech Stack

- Laravel 13 / PHP 8.4+
- Filament v4 Admin Panel
- MySQL 8.4 (via Laravel Sail)
- Vite + Custom Tailored Royal Brown UI Theme

## Modules

The ERP contains 9 interconnected modules:

1. **CRM**: Contacts, Clients, Deals, Leads
2. **Sales**: Quotations, Orders, Invoices
3. **Inventory**: Products, Warehouses, Stock Movements
4. **Purchases**: Vendors, Purchase Orders, Bills
5. **Accounting**: Accounts, Journals, Journal Entries
6. **HR**: Employees, Payroll
7. **Projects**: Projects, Tasks, Timesheets
8. **Manufacturing**: Bills of Material (BOM), Production Orders
9. **Dashboard & Settings**: Widgets, Bilingual (EN/AR), Switchable Themes

## Local Development (Sail)

Start the environment and run migrations/seeders to populate demo data:

```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate:fresh --seed
```

Access the ERP at `http://localhost/erp`

## Tests

Execute the Pest test suite:

```bash
./vendor/bin/sail artisan test
```
