<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Business;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class InvoiceDiscounting extends Model
{
    use HasUlids;
       protected $guarded = [];

       public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
