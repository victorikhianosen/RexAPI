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
        Schema::create('businesses', function (Blueprint $table) {
            $table->ulid('id')->primary(); // ✅ UUID primary key

            // Owner Info
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('maiden_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_number')->unique();
            $table->string('password');
            $table->string('transaction_pin')->nullable();


            // OTP
            $table->string('otp')->nullable();
            $table->timestamp('otp_expired_at')->nullable();
            $table->timestamp('otp_verified_at')->nullable();

            // Status
            $table->enum('status', ['active', 'inactive', 'pending', 'approved', 'rejected', 'disable', 'deleted'])->default('pending');

            // Business Info
            $table->string('business_logo')->nullable();
            $table->string('business_name')->nullable();
            $table->string('industry')->nullable();
            $table->integer('years_in_business')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('business_type')->nullable();
            $table->string('business_phone')->nullable();

            // Location
            $table->string('address')->nullable();
            $table->string('lga')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable()->default('Nigeria');
            $table->integer('years_at_location')->nullable();

            // Documents
            $table->string('tin')->nullable();
            // $table->string('cac_certificate')->nullable();
            // $table->string('valid_id')->nullable();
            // $table->string('utility_bill')->nullable();
            // $table->string('auditing_account_picture')->nullable();
            $table->boolean('terms')->default(false);


            $table->ipAddress('last_login_ip')->nullable();
            $table->string('last_login_location')->nullable();
            $table->string('last_login_device')->nullable(); // e.g., "iPhone 15, Chrome"

            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('last_logout_at')->nullable();

            $table->unsignedTinyInteger('login_attempts')->default(0);
            $table->boolean('is_locked')->default(false);
            $table->string('lock_reason')->nullable();

            // Registration device/location
            $table->ipAddress('registration_ip')->nullable();
            $table->string('registration_location')->nullable();
            $table->string('registration_device')->nullable();


            // $table->string('security_question')->nullable();
            // $table->string('security_answer')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
