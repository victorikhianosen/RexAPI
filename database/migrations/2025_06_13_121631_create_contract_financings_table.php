<?php

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
        Schema::create('contract_financings', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('business_id')->constrained()->cascadeOnDelete();

            // Loan basic details
            $table->string('loan_code')->unique();
            $table->decimal('requested_amount', 20, 2)->nullable();   // Requested by business
            $table->decimal('principal', 20, 2)->nullable();          // Approved amount (loan principal)
            $table->decimal('disbursed_amount', 20, 2)->nullable();   // Actually disbursed
            $table->boolean('is_disbursed')->default(false);
            $table->dateTime('disbursed_at')->nullable();
            $table->decimal('interest_rate', 5, 2)->nullable();       // e.g., 12.5
            $table->decimal('processing_fee', 20, 2)->nullable();

            $table->text('repayment_terms')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->integer('duration')->nullable(); // e.g. 12
            $table->enum('duration_unit', ['days', 'months'])->nullable();
            $table->string('tenor')->nullable(); // optional

            // Contract-related details
            $table->string('contract_type')->nullable();
            $table->string('counter_party')->nullable();
            $table->string('contract_agrrement_picture')->nullable();
            $table->string('contract_value')->nullable();
            $table->string('contract_execution_period')->nullable();
            $table->string('board_resolution_picture')->nullable();

            // Bank details
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_statement_consent')->nullable();

            // Collateral
            $table->string('collateral_type')->nullable();
            $table->string('collateral_description')->nullable();
            $table->string('proof_of_ownership_picture')->nullable();
            $table->string('audited_account_picture')->nullable();

            // Authentication
            $table->string('mbs_token')->nullable();
            $table->string('mbs_pin')->nullable();

            // Additional documents
            $table->string('offer_letter_picture')->nullable();
            $table->string('letter_of_introduction_picture')->nullable();
            $table->string('approval_document')->nullable();

            // Status tracking
            $table->enum('status', [
                'draft',
                'pending',
                'approved',
                'rejected',
                'disbursed',
                'completed',
                'closed',
                'review'
            ])->default('draft');

            $table->foreignUlid('approved_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->dateTime('approved_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_financings');
    }
};
