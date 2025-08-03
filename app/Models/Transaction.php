<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Business;
use App\Models\ContractFinancing;
use Illuminate\Database\Eloquent\Model;
use App\Models\GeneralLedgerTransaction;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Transaction extends Model
{
    use HasUlids;
        protected $guarded = [];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function contractFinancing()
    {
        return $this->belongsTo(ContractFinancing::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function generalLedgerTransactions()
    {
        return $this->hasMany(GeneralLedgerTransaction::class);
    }
}
