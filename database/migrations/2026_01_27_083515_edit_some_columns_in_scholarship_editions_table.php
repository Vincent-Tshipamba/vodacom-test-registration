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
        Schema::table('scholarship_editions', function (Blueprint $table) {
            $table->renameColumn('start_date', 'application_start_date');
            $table->renameColumn('end_date', 'application_end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scholarship_editions', function (Blueprint $table) {
            $table->renameColumn('application_start_date', 'start_date');
            $table->renameColumn('application_end_date', 'end_date');
        });
    }
};
