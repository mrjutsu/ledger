<?php

namespace Mrjutsu\Ledger\Models;

use Illuminate\Database\Eloquent\Model;

class LedgerMeta extends Model
{
    const META_KEY = 'meta_key';
    const META_VALUE = 'meta_value';
    const LEDGER_META_ID = 'ledger_meta_id';
    const LEDGER_META_TYPE = 'ledger_meta_type';
    
    protected $fillable = [
        self::META_KEY,
        self::META_VALUE,
        self::LEDGER_META_ID,
        self::LEDGER_META_TYPE
    ];

    public function ledger_meta()
    {
        return $this->morphTo();
    }
}