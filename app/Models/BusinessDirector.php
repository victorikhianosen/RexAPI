<?php

namespace App\Models;

use App\Models\Business;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class BusinessDirector extends Model
{
  use HasUlids;
    protected $guarded = [];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
