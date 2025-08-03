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
        Schema::create('branches', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country')->default('Nigeria');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended', 'pending', 'banned', 'terminated', 'deleted'])->default('active');
            $table->timestamps();
        });



        DB::table('branches')->insert([
            [
                'id' => (string) Str::ulid(),
                'name' => 'Victoria Island Branch',
                'code' => 'VIB001',
                'address' => '12 Adeola Odeku Street',
                'city' => 'Lagos',
                'state' => 'Lagos',
                'country' => 'Nigeria',
                'phone' => '08012345678',
                'email' => 'vib@yourbank.test',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Enugu Central Branch',
                'code' => 'EN001',
                'address' => '5 Nnamdi Azikiwe Avenue',
                'city' => 'Enugu',
                'state' => 'Enugu',
                'country' => 'Nigeria',
                'phone' => '08087654321',
                'email' => 'enugu@yourbank.test',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
