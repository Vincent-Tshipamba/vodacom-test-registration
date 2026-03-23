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
        Schema::create('interview_phase_criterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_phase_id')->constrained('interview_phases')->cascadeOnDelete();
            $table->unsignedInteger('criteria_id');
            $table->foreign('criteria_id')->references('id')->on('evaluation_criteria')->cascadeOnDelete();
            $table->integer('ponderation')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_phase_criterias');
    }
};
