# Changelog

## v0.0.2

- Adds the `ledger.php` configuration file.
- Changes the `ledger_logs` table to allow `null` in the `user_id` column.
- Adds logic to log when a new user creates an account, if desired.
- Bug fixes.

## v0.0.1

This is the initial project version. It includes a small set of observers that observe and
log four basic actions: `created`, `updated`, `deleted` and `forceDeleted`.

- Added initial README.