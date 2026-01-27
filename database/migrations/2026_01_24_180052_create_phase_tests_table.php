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
        Schema::create('phase_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('scholarship_edition_id');
            $table->foreign('scholarship_edition_id')->references('id')->on('scholarship_editions')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->integer('duration')->default(60);
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->integer('total_questions')->default(0);
            $table->integer('passing_score')->default(50);
            $table->string('status')->default('AWAITING'); //PENDING, AWAITING, CANCELLED, COMPLETED
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phase_tests');
    }
};
