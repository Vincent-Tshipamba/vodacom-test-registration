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
        Schema::create('interview_phases', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->unsignedInteger('scholarship_edition_id');
            $table->foreign('scholarship_edition_id')->references('id')->on('scholarship_editions')->cascadeOnDelete();
            $table->integer('duration')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_phases');
    }
};
