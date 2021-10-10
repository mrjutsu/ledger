<?php

namespace Mrjutsu\Ledger\Models;

use Illuminate\Database\Eloquent\Model;

class LedgerMeta extends Model
{
    protected $fillable = [
        'meta_key',
        'meta_value',
        'ledger_meta_id',
        'ledger_meta_type'
    ];

    public function ledger_meta()
    {
        return $this->morphTo();
    }
}