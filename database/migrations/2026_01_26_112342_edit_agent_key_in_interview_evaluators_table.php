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
        Schema::table('interview_evaluators', function (Blueprint $table) {
            $table->dropForeign(['evaluator_id']);
            $table->foreignId('evaluator_id')->change()->constrained('agents')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interview_evaluators', function (Blueprint $table) {
            $table->foreignId('evaluator_id')->constrained('staff_profiles')->cascadeOnDelete();
        });
    }
};
