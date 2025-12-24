<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('application_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('applicant_id')->constrained('applicants')->cascadeOnDelete();
            $table->string('document_type', 50); // PHOTO, ID, DIPLOMA, RECO_LETTER
            $table->string('file_url', 500);
            $table->string('file_name', 100);
            $table->boolean('is_valid')->nullable(); // null=pending
            $table->unsignedBigInteger('reviewed_by_agent')->nullable();
            $table->unsignedBigInteger('reviewed_by_scholar')->nullable();
            $table->foreign('reviewed_by_agent')->references('id')->on('staff_profiles')->nullOnDelete();
            $table->foreign('reviewed_by_scholar')->references('id')->on('scholars')->nullOnDelete();
            $table->dateTime('uploaded_at')->useCurrent();
            $table->dateTime('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_documents');
    }
};
