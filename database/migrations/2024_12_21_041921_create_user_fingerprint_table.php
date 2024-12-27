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
        Schema::create('user_fingerprint', function (Blueprint $table) {
            $table->id();
            $table->string('user_id'); // Ensure custom_id in users is also a string
            $table->binary('fingerprint_id');
            $table->binary('fingerprint_id2');
            $table->binary('fingerprint_id3'); // Use binary for storing BLOB data
            $table->string('status'); // Use snake_case for consistency
            // Foreign key constraint
            $table->foreign('user_id')->references('custom_id')->on('users')->onDelete('cascade');
        
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_fingerprint');
    }
};
