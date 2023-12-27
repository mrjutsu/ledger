<?php

namespace Mrjutsu\Ledger;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Verified;
use Mrjutsu\Ledger\Listeners\LogAuthenticated;
use Mrjutsu\Ledger\Listeners\LogFailed;
use Mrjutsu\Ledger\Listeners\LogLogin;
use Mrjutsu\Ledger\Listeners\LogLogout;
use Mrjutsu\Ledger\Listeners\LogVerified;

class Ledger
{
    const CREATED_ACTION = 'Created';
    const DELETED_ACTION = 'Deleted';
    const DELETING_ACTION = 'Deleting';
    const FORCE_DELETED_ACTION = 'Force Deleted';
    const REPLICATING_ACTION = 'Replicating';
    const RESTORED_ACTION = 'Restored';
    const RESTORING_ACTION = 'Restoring';
    const SAVED_ACTION = 'Saved';
    const UPDATED_ACTION = 'Updated';
    const REGISTERED_ACTION = 'Registered';

    /*
     * Authentication
     * */
    const LOGGEDIN_ACTION = 'Logged In';
    const FAILED_ACTION = 'Log In Failed';
    const LOGOUT_ACTION = 'Logged Out';
    const AUTHENTICATED_ACTION = 'Authenticated';
    const VERIFIED_ACTION = 'Verified Email';

    const LOGIN_LISTENER = LogLogin::class;
    const FAILED_LISTENER = LogFailed::class;
    const LOGOUT_LISTENER = LogLogout::class;
    const AUTHENTICATED_LISTENER = LogAuthenticated::class;
    const VERIFIED_LISTENER = LogVerified::class;

    const ALL_EVENTS = [
        Login::class => [
            self::LOGIN_LISTENER,
        ],
        Failed::class => [
            self::FAILED_LISTENER,
        ],
        Logout::class => [
            self::LOGOUT_LISTENER,
        ],
        Authenticated::class => [
            self::AUTHENTICATED_LISTENER,
        ],
        Verified::class => [
            self::VERIFIED_LISTENER,
        ],
    ];

    private const LISTENER_MAP = [
        'Login' => self::LOGIN_LISTENER,
        'Failed' => self::FAILED_LISTENER,
        'Logout' => self::LOGOUT_LISTENER,
        'Authenticated' => self::AUTHENTICATED_LISTENER,
        'Verified' => self::VERIFIED_LISTENER,
    ];

    private const EVENT_MAP = [
        'Login' => Login::class,
        'Failed' => Failed::class,
        'Logout' => Logout::class,
        'Authenticated' => Authenticated::class,
        'Verified' => Verified::class,
    ];

    /**
     * Specify which authentication events to log.
     *
     * Receives a list of strings where each string is an authentication event dispatched by Laravel.
     * By default, all authentication events will be observed, otherwise you may provide your own
     * list of events you wish to log.
     *
     * @param array $events
     * @return array|array[]
     */
    public static function logAuthenticationEvents(array $events = ['*']): array
    {
        if (! config('ledger.log_authentication_events', true)) {
            return [];
        }

        if ($events === ['*']) {
            return self::ALL_EVENTS;
        } else {
            $actions = [];

            foreach ($events as $event) {
                if (array_key_exists($event, self::EVENT_MAP)) {
                    $actions[self::EVENT_MAP[$event]] = [
                        self::LISTENER_MAP[$event]
                    ];
                }
            }

            return $actions;
        }
    }
}