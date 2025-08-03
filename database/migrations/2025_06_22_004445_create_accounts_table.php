<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('business_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('account_type_id')->constrained()->cascadeOnDelete();
            $table->string('account_number')->unique();
            $table->string('currency')->default('NGN');
            $table->enum('status', ['active', 'inactive', 'suspended', 'pending', 'closed', 'deleted'])->default('active');
            $table->decimal('account_balance', 24, 2)->default(0.00);  // Display balance
            $table->decimal('available_balance', 24, 2)->default(0.00); // Available for withdrawal or use
            $table->decimal('transfer_limit', 15, 0)->default(100000.00);  // Daily or per-transaction
            $table->decimal('withdrawal_limit', 15, 0)->default(100000);
            $table->enum('tier', ['tier_1', 'tier_2', 'tier_3'])->default('tier_1');
            $table->decimal('lien_amount', 24, 2)->default(0.00);       // Amount held temporarily
            $table->decimal('lien_deducted', 24, 2)->default(0.00);     // Already applied lien
            $table->decimal('lien_remaining', 24, 2)->default(0.00);    // Remaining lien to deduct
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
