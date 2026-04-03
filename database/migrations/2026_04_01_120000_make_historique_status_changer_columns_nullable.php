<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('historique_status_changes', function (Blueprint $table) {
            $table->dropForeign(['changed_by_agent_id']);
            $table->dropForeign(['changed_by_scholar_id']);
        });

        Schema::table('historique_status_changes', function (Blueprint $table) {
            $table->foreignId('changed_by_agent_id')->nullable()->change();
            $table->foreignId('changed_by_scholar_id')->nullable()->change();
        });

        Schema::table('historique_status_changes', function (Blueprint $table) {
            $table->foreign('changed_by_agent_id')->references('id')->on('agents')->nullOnDelete();
            $table->foreign('changed_by_scholar_id')->references('id')->on('scholars')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('historique_status_changes', function (Blueprint $table) {
            $table->dropForeign(['changed_by_agent_id']);
            $table->dropForeign(['changed_by_scholar_id']);
        });

        Schema::table('historique_status_changes', function (Blueprint $table) {
            $table->foreignId('changed_by_agent_id')->nullable(false)->change();
            $table->foreignId('changed_by_scholar_id')->nullable(false)->change();
        });

        Schema::table('historique_status_changes', function (Blueprint $table) {
            $table->foreign('changed_by_agent_id')->references('id')->on('agents')->cascadeOnDelete();
            $table->foreign('changed_by_scholar_id')->references('id')->on('scholars')->cascadeOnDelete();
        });
    }
};
