<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidats', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('code_exetat', 14);
            $table->string('identity');
            $table->string('certificate');
            $table->string('coupon')->unique(); // Coupon unique à 5 caractères
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidats');
    }
};
