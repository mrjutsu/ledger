# Changelog

## v0.11.0

- Removes unused observers.

## v0.10.0

- Removes the `LedgerMeta` model and migration.
- Overrides the `replicate` method in order to properly log when they model is being replicated.

## v0.9.1

- Fixes the `LedgerMeta` table assignment.

## v0.9.0

- Adds the `LedgerMeta` model.
- Adds methods for the `LedgerMeta` model in `ModelObserver`.
- Saves and fetches metadata to verify if a model was replicated when saving.

## v0.8.3

- Fixes the replicating helper methods.

## v0.8.2

- Moves the replicating methods to the `Loggable` trait so they're available to the models.

## v0.8.1

- Improves the model replication check.

## v0.8.0

- Moves field changes checking logic into an independent method.
- Add comments to the methods in `ModelObserver`.
- Adjusts the `SavedObserver` to accurately log when a model was replicated.

## v0.7.2

- Fixes a call to the `$fields` variable inside `getLoggedFields()`.

## v0.7.1

- Changes all model properties to constants.
- Updates the README to reflect the changes.

## v0.7.0

- Removes `retrieved` observer.
- Changes the declared observers and logged events from static properties to model constants.

## v0.6.1

- Moves the `user` relationship from the `Loggable` trait to the `LedgerLog` model.
- Fixes an issue with the properties declared in the `Loggable` trait and the ones used in the models.

## v0.6.0

- Changes the string fields in `LedgerLog` to constants.
- Adds a method to delete the prior logged Deleted action when a force delete happens.
- Adds a configuration option to specify if the developer wants to remove the Deleted action prior to the Force Deleted one.

## v0.5.4

- Corrects the `maybeLogUserRegistration` method.
- Moves the event constants from their observers and into the `ModelObserver`.

## v0.5.3

- Improves logic when creating a new User and validates whether the action should be logged as Created or a new registration.

## v0.5.2

- Corrects the property type for `$ledgerObservers`.

## v0.5.1

- Corrects the used observers assignment and the way they can be overridden.

## v0.5.0

- Adds the possibility to override the default observers.

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