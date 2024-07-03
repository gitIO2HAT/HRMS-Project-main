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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->tinyInteger('user_type');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('lastname', 255);
            $table->string('middlename', 30);
            $table->enum('suffix', ['Jr.','Sr.','I','II','III'])->nullable();
            $table->enum('sex', ['Male','Female','Other']);
            $table->integer('age')->default(18);
            $table->date('birth_date')->nullable();
            $table->string('phonenumber', 20);
            $table->enum('department', ['Department 1','Department 2','Department 3','Department 4','Department 5','Department 6','Department 7']);
            $table->enum('position', ['Position 1','Position 2','Position 3','Position 4','Position 5','Position 6','Position 7','Position 8','Position 9','Position 10']);
            $table->decimal('daily_rate', 10, 2);
            $table->decimal('credit', 10, 2)->default(0.00);
            $table->string('custom_id', 20)->nullable();
            $table->date('end_of_contract')->nullable();
            $table->enum('is_archive', ['1','2'])->default('1');
            $table->datetime('date_archive')->nullable();
            $table->enum('civil_status', ['Single','Married','Widowed'])->nullable();
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
                'department' => 'Department 1',
                'position' => 'Position 1',
                'daily_rate' => 100.00,
                'credit' => 50.00,
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
            [
                'name' => 'Admin',
                'lastname' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => '$2y$12$Ws2RpZt7NiRG0nAtutz/aeyH6sE3eGyFWl5WXRv2pr5F1JB3or0X.',
                'user_type' => 1,
                'profile_pic' => 'admin.png',
                'middlename' => 'Middle',
                'sex' => 'Other',
                'age' => 35,
                'birth_date' => '1987-08-20',
                'phonenumber' => '9876543210',
                'department' => 'Department 2',
                'position' => 'Position 2',
                'daily_rate' => 120.00,
                'credit' => 75.00,
                'custom_id' => '2',
                'end_of_contract' => '2024-06-30',
                'is_archive' => '1',
                'civil_status' => 'Married',
                'fulladdress' => '456 Second St, City, Country',
                'emergency_fullname' => 'Emergency Contact 2',
                'emergency_fulladdress' => '789 Emergency St, City, Country',
                'emergency_phonenumber' => '1234567890',
                'emergency_relationship' => 'Spouse',
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
