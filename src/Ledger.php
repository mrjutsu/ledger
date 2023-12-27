<?php

namespace Mrjutsu\Ledger;

use Illuminate\Auth\Events\Login;
use Mrjutsu\Ledger\Listeners\LogLogin;

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
    const LOGGEDIN_ACTION = 'Logged In';

    const LOGIN_LISTENER = LogLogin::class;

    const ALL_EVENTS = [
        Login::class => [
            self::LOGIN_LISTENER,
        ],
    ];

    private const LISTENER_MAP = [
        'Login' => self::LOGIN_LISTENER,
    ];

    private const EVENT_MAP = [
        'Login' => Login::class,
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
        if ($events === ['*'] || empty($events)) {
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

            if (empty($actions)) {
                return self::ALL_EVENTS;
            }

            return $actions;
        }
    }
}