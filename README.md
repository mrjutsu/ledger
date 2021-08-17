# Ledger

## Introduction

Ledger is a package that aims to offer a nonrepudiation service by letting you log every single action performed on an Eloquent model. Ledger will help you know who did what when.

## Installation

Make sure to add

`\Mrjutsu\Ledger\LedgerServiceProvider::class`

to the list of providers in your application's `app.php` file.

After that, run the following command to publish the package's assets.

`php artisan vendor:publish --provider="Mrjutsu\Ledger\LedgerServiceProvider"`

This will publish migrations and a `ledger.php` config file located in your application's `config` directory.

After assets are published, run migrations.

`php artisan migrate`

## Getting Started

Using Ledger's basic features is very simple, just add the `Loggable` trait to the model you wish to log.

```php
use Mrjutsu\Ledger\Traits\Loggable;

class User extends Model {
    use Loggable;
}
```

### Default Behavior

By default, Ledger will log the following events:
- `created`
- `updated`
- `deleted`
- `forceDeleted`

### Logging Certain Events Only

Logging only certain events is also very easy with Ledger.

In your model, create a static property called `eventsLogged`, this will be
an array that stores the names of the events you wish to log.

```php
use Mrjutsu\Ledger\Traits\Loggable;

class User extends Model {
    use Loggable;
    
    public static $eventsLogged = [
        'created',
        'saved',
        'deleted'
    ];
}
```

### Available Events To Log

Ledger logs all Eloquent events, if you wish to see a list of them as well as learning more about
them, please visit the official [Laravel Documentation](https://laravel.com/docs/8.x/eloquent#events).

## Limitations

Currently, Ledger is in its early stages and considerable shaping is necessary and will definitely come. Having said that, these are its current limitations:

- Actions logged are very simple and currently there is no support for custom ones, like logging a download, for example.

## Roadmap

Ledger is a package I'm expanding and maintaining in my free time, so I won't be able to provide a specific time on when a new feature, fix or improvement will be released.

If you do wish to track the status of a given project head to the [Projects list](https://github.com/mrjutsu/Ledger/projects), over there you will see what's currently cooking and how many tasks are left.

## Contributing

If you wish to contribute to the project, follow these instructions:

- Fork the project.
- Give your branch a descriptive name, e.g.: `feature/my-awesome-feature`, `bugfix/issue-fix` or `improvement/some-optimization`, for example.
- Do your thing.
- Pull `main` into your branch.
- Make a Pull Request.
