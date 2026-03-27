<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('interview_evaluators', function (Blueprint $table) {
            $table->string('coupon', 32)->nullable()->unique()->after('evaluator_id');
            $table->string('qr_token', 64)->nullable()->unique()->after('coupon');
        });
    }

    public function down(): void
    {
        Schema::table('interview_evaluators', function (Blueprint $table) {
            $table->dropColumn(['coupon', 'qr_token']);
        });
    }
};
