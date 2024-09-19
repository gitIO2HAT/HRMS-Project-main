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
        Schema::create('credits_balance', function (Blueprint $table) {
            $table->id();
            $table->decimal('vacation_leave', 10, 3)->nullable();
            $table->decimal('sick_leave',10, 3)->nullable();
            $table->decimal('special_previlege_leave',10, 3)->default(3);
            $table->decimal('maternity_leave',10, 3)->default(105);
            $table->decimal('paternity_leave',10, 3)->default(7);
            $table->decimal('solo_parent_leave',10, 3)->default(7);
            $table->decimal('study_leave',10, 3)->default(240);
            $table->decimal('vawc_leave',10, 3)->default(10);
            $table->decimal('rehabilitation_leave',10, 3)->default(240);
            $table->decimal('special_leave_benefits_for_women',2)->default(60);
            $table->decimal('special_emergency_leave',10, 3)->default(5);
            $table->string('monetization_leave',255)->nullable();
            $table->string('terminal_leave',255)->nullable();
            $table->string('adoption_leave',255)->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credits_balance');
    }
};
