<?php

namespace App\Models;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use App\Models\GeneralLedgerTransaction;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class GeneralLedger extends Model
{
    use HasUlids;

        protected $guarded = [];

      public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function transactions()
    {
        return $this->hasMany(GeneralLedgerTransaction::class);
    }
}
