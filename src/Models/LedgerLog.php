<?php

namespace Mrjutsu\Ledger\Models;

use Illuminate\Database\Eloquent\Model;

class LedgerLog extends Model
{
    const ACTION = 'action';
    const DETAILS = 'details';
    const USER_ID = 'user_id';
    const LOGGABLE_ID = 'loggable_id';
    const LOGGABLE_TYPE = 'loggable_type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::ACTION,
        self::DETAILS,
        self::USER_ID,
        self::LOGGABLE_ID,
        self::LOGGABLE_TYPE,
    ];


    public function loggable()
    {
        return $this->morphTo();
    }
    
    public function getDetailsAttribute($value)
    {
        return json_decode($value, true) ?? $value;
    }
}
