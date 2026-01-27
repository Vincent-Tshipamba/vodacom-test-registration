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
        Schema::table('historique_status_changes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('changed_by_agent_id');
            $table->foreignId('changed_by_agent_id')->constrained('agents')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historique_status_changes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('changed_by_agent_id');
            $table->foreignId('changed_by_agent_id')->constrained('staff_profiles')->cascadeOnDelete();
        });
    }
};
