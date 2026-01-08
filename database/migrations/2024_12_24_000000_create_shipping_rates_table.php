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
        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->string('origin_city');
            $table->string('origin_province');
            $table->string('destination_city');
            $table->string('destination_province');
            $table->integer('distance_km')->default(0);
            $table->decimal('base_rate', 10, 2)->default(5000); // Base rate in IDR
            $table->decimal('rate_per_km', 10, 2)->default(1000); // Rate per km in IDR
            $table->timestamps();
            
            // Index untuk pencarian cepat
            $table->index(['origin_city', 'origin_province']);
            $table->index(['destination_city', 'destination_province']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_rates');
    }
};
