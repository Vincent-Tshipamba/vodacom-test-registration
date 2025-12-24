<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scholars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('applicant_id')->constrained('applicants')->cascadeOnDelete();
            $table->unsignedInteger('university_id');
            $table->foreign('university_id')->references('id')->on('universities')->cascadeOnDelete();
            $table->string('matricule', 50)->unique();
            $table->string('chosen_field', 100);
            $table->string('status', 50)->default('ACTIVE'); // ACTIVE, SUSPENDED, ALUMNI
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholars');
    }
};
