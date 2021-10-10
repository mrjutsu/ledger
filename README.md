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

In your model, create a constant called `EVENTS_LOGGED`, this will be
an array that stores the names of the events you wish to log.

```php
use Mrjutsu\Ledger\Traits\Loggable;

class User extends Model {
    use Loggable;
    
    const EVENTS_LOGGED = [
        'created',
        'saved',
        'deleted'
    ];
}
```

### Logging Changes To Certain Fields

Sometimes you might want to know what was changed to specific fields besides just knowing that the model was changed.
For these cases, you can use the `FIELDS_LOGGED` constant.

```php
use Mrjutsu\Ledger\Traits\Loggable;

class User extends Model {
    use Loggable;
    
    const FIELDS_LOGGED = [
        'name',
        'email',
        'address'
    ];
}
```

In the above example, when the user gets `saved`, the event will be logged as it should, but additionally, changes made to
those fields will be stored in a `fields` object, containing the changed fields as keys and a nested object containing the old and new values.

By default, this will be an empty array.

```php
$user = User::find(1);
// ['name' => 'John Doe', 'email' => 'email@example.com']

$user->name = 'Foo Bar';
$user->email = 'foo@bar.com';
$user->role = 'client';
$user->save();

$log = $user->ledgerLogs()->first();
$log->details;
//[
//    'fields' => [
//        'name' => [
//            'old' => 'John Doe',
//            'new' => 'Foo Bar'
//        ],
//        'email' => [
//            'old' => 'email@example.com',
//            'new' => 'foo@bar.com'
//        ],
//    ]
//]
```

In the above example, `role` is not logged because it was not declared in `FIELDS_LOGGED`.

If you wish to log changes made to all the fields, just add a `*` to the `FIELDS_LOGGED` array,
Ledger will see this and log changes made to all the model's fields, except those ignored.

`const FIELDS_LOGGED = ['*']`

Even if a field is logged, if no changes are made to it, it won't be logged.

### Ignoring Certain Fields

Similarly to how you can log certain fields, you can also ignore changes done to them.

By default, Ledger will always ignore the model's primary key and its timestamp fields, if they're used.

If you wish to ignore more fields, you can add them to the `FIELDS_IGNORED` constant.

### Custom Actions

Ledger allows you to log when a custom action is performed in a very simple way. To do so, just call the `log()` method
on the loggable model and pass the action to log, you can also pass details as either a string or an array.

```php
use Mrjutsu\Ledger\Traits\Loggable;

class Message extends Model {
    use Loggable;
    
    public function downloadFile($filename)
    {
        $details = sprintf('User downloaded: %s', $filename);
        
        $this->log('Downloaded', $details);
    }
    
    public function uploadFile($filename)
    {
        $details = [
            'filename' => $filename,
            'foo' => 'bar'
        ];
        
        $this->log('Uploaded', $details);
    }
}
```

### Available Events To Log

Ledger logs all Eloquent events, if you wish to see a list of them as well as learning more about
them, please visit the official [Laravel Documentation](https://laravel.com/docs/8.x/eloquent#events).

### Using Your Own Observers

Ledger allows you to extend from its main class `ModelObserver` should you wish to perform a custom action prior to an event being logged.

In order to do so, you must first declare the observer action and its class, this is done in a constant array called `OBSERVERS`,
in it, you will specify the event as the key and your observer as the value.

In your model:

```php
use Mrjutsu\Ledger\Traits\Loggable;

class User extends Model {
    use Loggable;
    
    const OBSERVERS = [
        'created' => MyCreatedObserver::class,
    ];
}
```

Then, your observer should extend from `ModelObserver`.

```php
use Mrjutsu\Ledger\Observers\ModelObserver;
use \Illuminate\Database\Eloquent\Model;

class MyCreatedObserver extends ModelObserver {
    public function created(Model $model)
    {
        // Your logic goes here
        
        $this->logAction($model, 'Your Action');
    }
}
```

## Roadmap

Ledger is a package I'm expanding and maintaining in my free time, so I won't be able to provide a specific time on when a new feature, fix or improvement will be released.

If you do wish to track the status of a given project head to the [projects list](https://github.com/mrjutsu/Ledger/projects), over there you will see what's currently cooking and how many tasks are left.

## Contributing

If you wish to contribute to the project, follow these instructions:

- Fork the project.
- Give your branch a descriptive name, e.g.: `feature/my-awesome-feature`, `bugfix/issue-fix` or `improvement/some-optimization`, for example.
- Do your thing.
- Pull `main` into your branch.
- Make a Pull Request.
