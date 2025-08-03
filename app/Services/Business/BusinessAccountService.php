<?php

namespace App\Services\Business;

use App\Models\Account;
use App\Models\AccountType;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BusinessAccountService
{


    /**
     * Create default savings account for a business.
     *
     * @param string $businessId
     * @return void
     */
    public function createSavingsAccount(string $businessId): void
    {
        $accountType = AccountType::where('code', 'SV100')->first();
        $accountNumber = $this->generateSavingsAccount();
        Account::create([
            'id' => Str::ulid(),
            'business_id' => $businessId,
            'account_type_id' => $accountType->id,
            'account_number' => $accountNumber,
        ]);
    }



    protected function generateSavingsAccount(): string
    {
        do {
            $prefix = '01';
            $suffix = str_pad((string) rand(0, 999999999), 9, '0', STR_PAD_LEFT);
            $accountNumber = $prefix . $suffix;
        } while (Account::where('account_number', $accountNumber)->exists());

        return $accountNumber;
    }


    // protected function generateSavingsAccount(): string
    // {
    //     do {
    //         $prefix = str_pad((string) rand(1, 10), 2, '0', STR_PAD_LEFT);
    //         $suffix = str_pad((string) rand(0, 999999999), 9, '0', STR_PAD_LEFT);
    //         $accountNumber = $prefix . $suffix;
    //     } while (Account::where('account_number', $accountNumber)->exists());
    //     return $accountNumber;
    // }
}
