<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('city', 100);
            $table->string('website_url', 255)->nullable();
            $table->string('contact_person_name', 150)->nullable();
            $table->string('contact_person_phone', 150)->nullable();
            $table->string('contact_person_grade', 150)->nullable();
            $table->string('contact_email', 150)->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('universities');
    }
};
