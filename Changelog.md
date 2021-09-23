# Changelog

## v0.4.0

- Adds the possibility to log custom actions.

## v0.3.0

- Adds `$fieldsLogged`, and with it, support to log changes made to specific fields.
- Adds `$fieldsIgnored`, and with it, support to ignore changes made to specific fields.

## v0.2.0

- Adds a `details` column to the `ledger_logs` table.
- Adds support to all the remaining Eloquent events.
- Stores the deleted model as a string in the `details` field. The data is then transformed into an associative array when retrieving it from the database.

## v0.1.0

- Adds the `ledger.php` configuration file.
- Changes the `ledger_logs` table to allow `null` in the `user_id` column.
- Adds logic to log when a new user creates an account, if desired.
- Bug fixes.

## v0.0.1

This is the initial project version. It includes a small set of observers that observe and
log four basic actions: `created`, `updated`, `deleted` and `forceDeleted`.

- Added initial README.