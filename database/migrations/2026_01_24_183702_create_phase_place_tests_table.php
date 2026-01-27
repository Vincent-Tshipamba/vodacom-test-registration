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
        Schema::create('phase_place_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phase_test_id')->constrained('phase_tests')->cascadeOnDelete();
            $table->foreignId('place_test_id')->constrained('place_tests')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phase_place_tests');
    }
};
