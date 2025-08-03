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
        Schema::create('general_ledger_transactions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('account_id')->nullable()->constrained('accounts')->cascadeOnDelete();
            $table->foreignUlid('business_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignUlid('admin_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignUlid('general_ledger_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 20, 2);
            $table->enum('entry_type', ['debit', 'credit']);
            $table->string('device')->nullable();
            $table->string('slip')->nullable();
            $table->string('reference_no')->unique();
            $table->text('note')->nullable();
            $table->enum('status', ['pending', 'approved', 'reversed', 'posted', 'failed','rejecteed', 'suucessfull'])->default('pending');
            $table->string('initiated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_ledger_transactions');
    }
};
