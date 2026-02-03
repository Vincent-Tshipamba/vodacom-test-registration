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
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn('diploma_city', 'current_city');
            $table->foreignId('educational_city_id')->constrained('educational_cities')->cascadeOnDelete();
            $table->foreignId('current_city_id')->constrained('educational_cities')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->string('diploma_city', 100);
            $table->string('current_city', 100);
            $table->dropConstrainedForeignId('educational_city_id');
            $table->dropConstrainedForeignId('current_city_id');
        });
    }
};
