<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\BusinessDirector;
use App\Models\ContractFinancing;
use Laravel\Sanctum\HasApiTokens;
use App\Models\InvoiceDiscounting;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Business extends Authenticatable
{
    use HasFactory, Notifiable, HasUlids, HasApiTokens;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
        'phone_number',
        'password',
        'transaction_pin',
        'otp',
        'otp_expired_at',
        'status',
        'business_logo',
        'business_name',
        'industry',
        'years_in_business',
        'registration_number',
        'business_type',
        'business_phone',
        'address',
        'lga',
        'state',
        'country',
        'years_at_location',
        'tin',
        'cac_certificate',
        'valid_id',
        'utility_bill',
        'terms',
        'ip_address',
        'location',
        'logged_in_at',
        'logged_in_at',
        'logged_out_at',

    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expired_at' => 'datetime',
        'years_in_business' => 'integer',
        'years_at_location' => 'integer',
            'is_locked' => 'boolean',

    ];


    protected $hidden = [
        'password',
        'transaction_pin',
        'otp',
        'otp_verified_at',
        'otp_expired_at',
        'remember_token', // if using
    ];


    public function directors()
    {
        return $this->hasMany(BusinessDirector::class);
    }

    public function contractFinancings()
    {
        return $this->hasMany(ContractFinancing::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function invoiceDiscounting()
    {
        return $this->hasMany(InvoiceDiscounting::class);
    }

    public function account()
    {
        return $this->hasMany(Account::class);
    }
}
