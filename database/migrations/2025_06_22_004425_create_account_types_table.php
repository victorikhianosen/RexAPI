<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('account_types', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('code')->unique(); // e.g. "CUR", "LN", "FIX"
            $table->string('name')->unique(); // e.g. "Current Account"
            $table->boolean('allow_overdraw')->default(false); // 0 or 1
            $table->decimal('interest_rate', 15, 2)->nullable(); // e.g. 12.50%
            $table->integer('minimum_balance')->default(0); // e.g. ₦1000
            $table->string('interest_posting')->nullable(); // e.g. "monthly", "quarterly"
            $table->boolean('interest_adding')->default(false); // Whether interest is added to balance

            $table->timestamps();
        });

        DB::table('account_types')->insert([
            [
                'id' => Str::ulid(),
                'code' => 'LN1001',
                'name' => 'Loan Account',
                'allow_overdraw' => false,
                'interest_rate' => 12.50,
                'minimum_balance' => 5000,
                'interest_posting' => 'monthly',
                'interest_adding' => true,
            ],
            [
                'id' => Str::ulid(),
                'code' => 'SV100',
                'name' => 'Savings Account',
                'allow_overdraw' => false,
                'interest_rate' => null,
                'minimum_balance' => 0,
                'interest_posting' => null,
                'interest_adding' => false,
            ],
            [
                'id' => Str::ulid(),
                'code' => 'CA200',
                'name' => 'Current Account',
                'allow_overdraw' => true,
                'interest_rate' => 0.00,
                'minimum_balance' => 0,
                'interest_posting' => null,
                'interest_adding' => false,
            ],
            [
                'id' => Str::ulid(),
                'code' => 'FD300',
                'name' => 'Fixed Deposit',
                'allow_overdraw' => false,
                'interest_rate' => 12.50,
                'minimum_balance' => 5000,
                'interest_posting' => 'monthly',
                'interest_adding' => true,
            ],
            [
                'id' => Str::ulid(),
                'code' => 'IV400',
                'name' => 'Investment Account',
                'allow_overdraw' => false,
                'interest_rate' => 12.50,
                'minimum_balance' => 5000,
                'interest_posting' => 'monthly',
                'interest_adding' => true,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_types');
    }
};
