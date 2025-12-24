<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('academic_year_record_id')->constrained('academic_year_records')->cascadeOnDelete();
            $table->decimal('amount', 10, 2)->default(1012.00);
            $table->string('currency', 3)->default('USD');
            $table->string('transaction_reference', 100)->nullable();
            $table->string('payment_status', 20)->nullable(); // PROCESSING, PAID, FAILED
            $table->dateTime('processed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
