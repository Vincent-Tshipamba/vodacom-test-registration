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
        Schema::table('application_documents', function (Blueprint $table) {
            $table->dropColumn('document_type');
            $table->dropConstrainedForeignId('reviewed_by_agent');

            $table->foreignId('document_type_id')->constrained('document_types')->cascadeOnDelete()->after('applicant_id');
            $table->foreignId('reviewed_by_agent')->constrained('agents')->cascadeOnDelete();
        });
        Schema::dropIfExists('staff_profiles');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_documents', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reviewed_by_agent');
            $table->dropForeign(['document_type_id']);

            $table->string('document_type', 100);
            $table->foreignId('reviewed_by_agent')->constrained('staff_profiles')->cascadeOnDelete();
        });

        Schema::create('staff_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete();
            $table->string('job_title', 100)->nullable();
            $table->timestamps();
        });
    }
};
