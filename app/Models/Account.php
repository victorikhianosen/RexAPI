<?php

namespace App\Models;

use App\Models\Business;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Account extends Model
{
    use HasUlids;

    protected $guarded = [];


    public function business() {
        return $this->belongsTo(Business::class);
    }
}
