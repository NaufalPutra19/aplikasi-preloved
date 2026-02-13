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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('escrow_status')->default('pending')->after('payment_status');
            // pending -> awaiting_payment -> received -> completed
            $table->timestamp('escrow_confirmed_at')->nullable()->after('paid_at');
            $table->timestamp('escrow_released_at')->nullable()->after('escrow_confirmed_at');
            $table->text('escrow_notes')->nullable()->after('escrow_released_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['escrow_status', 'escrow_confirmed_at', 'escrow_released_at', 'escrow_notes']);
        });
    }
};
