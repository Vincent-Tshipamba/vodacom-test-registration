<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidate_responses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('test_session_id')->constrained('test_sessions')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->unsignedBigInteger('selected_option_id')->nullable();
            $table->foreign('selected_option_id')->references('id')->on('answer_options')->nullOnDelete();
            $table->text('text_answer')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidate_responses');
    }
};
