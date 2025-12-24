<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scholarship_editions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->integer('year');
            $table->integer('scholar_quota')->default(0);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('status', 50)->default('SELECTION_PHASE'); // OPEN, CLOSED, ARCHIVED
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarship_editions');
    }
};
