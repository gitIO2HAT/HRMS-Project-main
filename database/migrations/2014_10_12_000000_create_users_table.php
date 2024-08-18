<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->tinyInteger('user_type');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('lastname', 255);
            $table->string('middlename', 30);
            $table->enum('suffix', ['Jr.', 'Sr.', 'I', 'II', 'III'])->nullable();
            $table->enum('sex', ['Male', 'Female', 'Other']);
            $table->integer('age')->default(18);
            $table->date('birth_date')->nullable();
            $table->string('phonenumber', 20);
            $table->string('department')->nullable();
            $table->string('position')->nullable();
            $table->decimal('daily_rate', 10, 2);
            $table->decimal('sick_balance', 10, 2)->default(0.0);
            $table->decimal('vacation_balance', 10, 2)->default(0.0);
            $table->string('custom_id', 20)->unique()->nullable(); // Add custom_id column here
            $table->date('end_of_contract')->nullable();
            $table->enum('is_archive', ['1', '2'])->default('1');
            $table->datetime('date_archive')->nullable();
            $table->enum('civil_status', ['Single', 'Married', 'Widowed'])->nullable();
            $table->text('fulladdress')->nullable();
            $table->string('emergency_fullname', 255)->nullable();
            $table->text('emergency_fulladdress')->nullable();
            $table->string('emergency_phonenumber', 20)->nullable();
            $table->string('emergency_relationship', 50)->nullable();
            $table->string('profile_pic', 255)->default('default.png');
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('users')->insert([
            [
                'name' => 'Super Admin',
                'lastname' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => '$2y$12$rtB0bLm5O.eHAz8czKUCwee.JBk1kziejszCU4FYP8TXobrQ5rLE2',
                'user_type' => 0,
                'profile_pic' => 'superadmin.png',
                'middlename' => 'Middle',
                'sex' => 'Other',
                'age' => 30,
                'birth_date' => '1992-05-15',
                'phonenumber' => '1234567890',
                'daily_rate' => 100.00,
                'custom_id' => '1',
                'end_of_contract' => '2023-12-31',
                'is_archive' => '1',
                'civil_status' => 'Single',
                'fulladdress' => '123 Main St, City, Country',
                'emergency_fullname' => 'Emergency Contact',
                'emergency_fulladdress' => '456 Emergency St, City, Country',
                'emergency_phonenumber' => '9876543210',
                'emergency_relationship' => 'Friend',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add other users as needed
        ]);
        DB::statement('UPDATE users SET age = TIMESTAMPDIFF(YEAR, birth_date, NOW())');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
