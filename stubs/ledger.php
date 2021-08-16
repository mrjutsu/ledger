<?php

return [
    /*
     * User Class
     *
     * Here you can specify your project's User class.
     *
     * */
    'user' => \App\Models\User::class,

    /*
     * User Primary Key
     *
     * If your User class has a primary key other than id, you can specify it here.
     *
     * */
    'user_primary_key' => 'id',
    
    /*
     * Log User Creation
     * 
     * There are cases where a new User creation won't have another User as a responsible, like
     * when someone registers for your application. This option allows you to specify if you
     * wish to log when that happens.
     * 
     * */
    'log_user_creation' => true,
    
    /*
     * New User Action
     * 
     * When a User registers, Ledger will set the action as the value specified here.
     * 
     * */
    'new_user_action' => 'Registered',
];