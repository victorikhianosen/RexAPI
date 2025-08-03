<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Transaction;
use App\Models\GeneralLedger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class GeneralLedgerTransaction extends Model
{
    use HasUlids;

        protected $guarded = [];

     public function generalLedger()
    {
        return $this->belongsTo(GeneralLedger::class);
    }

    public function initiatedBy()
    {
        return $this->belongsTo(Admin::class, 'initiated_by');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
