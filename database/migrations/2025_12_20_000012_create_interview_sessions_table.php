<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interview_sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('applicant_id')->constrained('applicants')->cascadeOnDelete();
            $table->dateTime('scheduled_at');
            $table->decimal('final_average_score', 5, 2)->nullable();
            $table->text('decision_comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interview_sessions');
    }
};
