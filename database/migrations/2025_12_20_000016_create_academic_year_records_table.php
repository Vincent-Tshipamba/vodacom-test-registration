<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_year_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('scholar_id')->constrained('scholars')->cascadeOnDelete();
            $table->string('academic_year_label', 20);
            $table->string('academic_level', 20);
            $table->boolean('registration_proof_submitted')->default(false);
            $table->boolean('scholarship_paid')->default(false);
            $table->boolean('payment_proof_submitted')->default(false);
            $table->string('final_result', 20)->default('PENDING'); // PENDING, PASS, FAIL
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_year_records');
    }
};
