<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluation_criteria', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('edition_id');
            $table->foreign('edition_id')->references('id')->on('scholarship_editions')->cascadeOnDelete();
            $table->string('criteria_name', 100);
            $table->integer('max_points')->default(10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_criteria');
    }
};
