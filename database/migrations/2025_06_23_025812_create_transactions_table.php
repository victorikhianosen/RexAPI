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
        Schema::create('transactions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('business_id')->constrained('businesses')->cascadeOnDelete()->nullable();
            $table->foreignUlid('admin_id')->constrained('admins')->cascadeOnDelete()->nullable();
            $table->foreignUlid('account_id')->constrained('accounts')->cascadeOnDelete()->nullable();
            $table->decimal('amount', 20, 2);
            $table->string('type');
            $table->string('device');
            $table->string('system_interest')->default('0.00');
            $table->string('destination_account')->nullable();
            $table->string('debit_account')->nullable();
            $table->string('reference_no')->unique();
            $table->string('note')->nullable();
            $table->enum('status', ['pending', 'approved', 'successful', 'failed', 'rejected'])->default('pending');
            $table->enum('entry', ['credit', 'debit']);
            $table->string('initiated_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('slip')->nullable();
            $table->string('payment_method')->nullable();
            $table->date('payment_date')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
