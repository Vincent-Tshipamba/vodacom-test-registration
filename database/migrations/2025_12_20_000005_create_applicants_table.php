<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedInteger('edition_id');
            $table->foreign('edition_id')->references('id')->on('scholarship_editions')->cascadeOnDelete();
            $table->string('registration_code', 50)->unique();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('gender', 10);
            $table->date('date_of_birth');
            $table->string('phone_number', 20);
            $table->string('vulnerability_type', 50)->default('NONE');
            $table->string('diploma_city', 100);
            $table->string('current_city', 100);
            $table->text('full_address');
            $table->string('school_name', 150);
            $table->string('national_exam_code', 14)->unique();
            $table->decimal('percentage', 5, 2);
            $table->string('option_studied', 100);
            $table->string('intended_field', 100);
            $table->text('intended_field_motivation');
            $table->text('intended_field_motivation_locale');
            $table->text('career_goals');
            $table->text('career_goals_locale');
            $table->text('additional_infos')->nullable();
            $table->text('additional_infos_locale')->nullable();
            $table->string('application_status', 50)->default('PENDING'); // PENDING, REJECTED, SHORTLISTED, TEST_PASSED, INTERVIEW_PASSED, ADMITTED
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
