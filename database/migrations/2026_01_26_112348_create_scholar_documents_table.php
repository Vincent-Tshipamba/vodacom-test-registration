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
        Schema::dropIfExists('scholarship_documents');
        Schema::create('scholar_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_year_record_id')->constrained('academic_year_records')->cascadeOnDelete();
            $table->foreignId('document_type_id')->constrained('document_types')->cascadeOnDelete();
            $table->string('file_url', 500);
            $table->string('file_name', 100);
            $table->string('verification_status', 20)->default('PENDING'); // PENDING, APPROVED, REJECTED
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->foreign('reviewed_by')->references('id')->on('agents')->nullOnDelete();
            $table->text('rejection_reason')->nullable();
            $table->dateTime('uploaded_at')->useCurrent();
            $table->dateTime('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholar_documents');
    }
};
