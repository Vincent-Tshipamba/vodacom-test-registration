<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scholarship_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('academic_year_record_id')->constrained('academic_year_records')->cascadeOnDelete();
            $table->string('document_type', 50); // REGISTRATION_PROOF, FEES_RECEIPT, RESULTS_PROOF
            $table->string('file_url', 500);
            $table->string('file_name', 100);
            $table->string('verification_status', 20)->default('PENDING');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->foreign('reviewed_by')->references('id')->on('staff_profiles')->nullOnDelete();
            $table->text('rejection_reason')->nullable();
            $table->dateTime('uploaded_at')->useCurrent();
            $table->dateTime('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarship_documents');
    }
};
