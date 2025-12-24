<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluation_scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('interview_evaluator_id');
            $table->foreign('interview_evaluator_id')->references('id')->on('interview_evaluators')->cascadeOnDelete();
            $table->unsignedInteger('criteria_id');
            $table->foreign('criteria_id')->references('id')->on('evaluation_criteria')->cascadeOnDelete();
            $table->integer('score_given');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_scores');
    }
};
