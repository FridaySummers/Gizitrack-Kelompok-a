# GiziTrack — Dusk Test Runner Guide

## Prerequisites

- Ensure Laravel's built-in server is running:

```bash
php artisan serve
```

- The Dusk ChromeDriver will be started automatically by the test runner.

## Run all PBI-19 to PBI-22 tests

```bash
php artisan dusk tests/Browser/FeedbackTest.php
```

## Run a single test

```bash
php artisan dusk --filter test_pbi19_001
php artisan dusk --filter test_pbi19_002
php artisan dusk --filter test_pbi19_003
php artisan dusk --filter test_pbi20_001
php artisan dusk --filter test_pbi20_002
php artisan dusk --filter test_pbi20_003
php artisan dusk --filter test_pbi21_001
php artisan dusk --filter test_pbi21_002
php artisan dusk --filter test_pbi21_003
php artisan dusk --filter test_pbi22_001
php artisan dusk --filter test_pbi22_002
```

## Reset DB before run

```bash
php artisan migrate:fresh --seed && php artisan dusk tests/Browser/FeedbackTest.php
```

This resets the SQLite database, seeds the test users, and runs all Feedback tests in one command.

## Run via PHPUnit directly

```bash
./vendor/bin/phpunit tests/Browser/FeedbackTest.php
./vendor/bin/phpunit --filter test_pbi21_002 tests/Browser/FeedbackTest.php
```

## Screenshots

Screenshots are captured automatically at the end of each test and saved to:

```
tests/Browser/screenshots/
```

Filename format: `test_pbi[XX]-[XXX]-[pass|fail].png`

Example:
- `test_pbi19-001-pass.png`
- `test_pbi21-003-pass.png`
- `test_pbi22-002-pass.png`

## Test Users (auto-created by setUp via DatabaseMigrations)

| Role      | Email                  | Password   |
|-----------|------------------------|------------|
| Admin     | admin@test.local        | password   |
| Vendor    | vendor@test.local       | password   |
| Sekolah 1 | sekolah@test.local      | password   |
| Sekolah 2 | sekolah2@test.local     | password   |

> **Note:** These users are created fresh per test via `setUp()` using `DatabaseMigrations`. No manual seeding is needed before running Dusk tests. Each test is fully independent.